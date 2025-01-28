<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
// use App\Models\Vehicle\VehicleModel;
use App\Models\Vehicle\VehicleInfo;
use App\Models\VehicleDetailModel;
use App\Models\Vehicle\VehiclesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use Yajra\DataTables\Facades\DataTables;

class VehicleRegistrationController extends Controller {
    // public function index()
    // {
    //     // dd( 'It is vehicle index baby ;)' );
    //     $vehicles = VehicleDetailModel::with( [ 'user', 'driver', 'details' ] )->get();

    //     return view( 'Vehicle_Registration.show', compact( 'vehicles' ) );
    // }
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function index() {
        $drivers = DriversModel::all();
        $vehicle = VehiclesModel::paginate( 6 ); 
        return view( 'Vehicle_Registration.show', compact( 'vehicle', 'drivers' ) );
    }
    public function list(Request $request)
    {
        $vehicle = VehiclesModel::get();
    
        return DataTables::of($vehicle)
            ->addIndexColumn()
            ->addColumn('plate_number', function($row){
                return $row->plate_number;
            })
            ->addColumn('vehicle_type', function($row){
                return $row->vehicle_type;
            })
            ->addColumn('vehicle_category', function($row){
                return $row->vehicle_category;
            })
            ->addColumn('action', function($row) {
                $actions = '<button type="button" class="btn btn-info rounded-pill view-btn" 
                                data-chancy_number="' . $row->vin . '"
                                data-make="' . $row->make . '"
                                data-model="' . $row->model . '"
                                data-year="' . $row->year . '"
                                data-plate_number="' . $row->plate_number . '"
                                data-mileage="' . $row->mileage . '"
                                data-capacity="' . $row->capacity . '"
                                data-fuel_amount="' . $row->fuel_amount . '"
                                data-fuel_type="' . $row->fuel_type . '"
                                data-last_service="' . $row->last_service . '"
                                data-next_service="' . $row->next_service . '"
                                data-vehicle_category="' . $row->vehicle_category . '"
                                data-position="' . $row->position . '"
                                data-vehicle_type="' . $row->vehicle_type . '"
                                data-rental_type="' . $row->rental_type . '"
                                data-libre="' . $row->libre . '"
                                data-insurance="' . $row->insurance . '"
                                title="View">
                                <i class="ri-eye-line"></i>
                            </button>
                            <button type="button" class="btn btn-secondary rounded-pill edit-btn" 
                                data-chancy_number="' . $row->vin . '"
                                data-make="' . $row->make . '"
                                data-model="' . $row->model . '"
                                data-year="' . $row->year . '"
                                data-plate_number="' . $row->plate_number . '"
                                data-mileage="' . $row->mileage . '"
                                data-capacity="' . $row->capacity . '"
                                data-fuel_amount="' . $row->fuel_amount . '"
                                data-fuel_type="' . $row->fuel_type . '"
                                data-last_service="' . $row->last_service . '"
                                data-next_service="' . $row->next_service . '"
                                data-vehicle_category="' . $row->vehicle_category . '"
                                data-position="' . $row->position . '"
                                data-vehicle_type="' . $row->vehicle_type . '"
                                data-rental_type="' . $row->rental_type . '"
                                data-libre="' . $row->libre . '"
                                data-insurance="' . $row->insurance . '"
                                title="Edit">
                                <i class="ri-pencil-line"></i>
                            </button>';
            
                return $actions;
            })            
            ->rawColumns(['plate_number','vehicle_type','vehicle_category','action'])
            ->make(true);
    }

    public function create() {
        return view( 'vehicles.create' );
    }
    public function store( Request $request ) {
        // dd($request);
        $user = Auth::id();
        $capacity = (int) $request->capacity;

        $validator = Validator::make( $request->all(), [
            'vin' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',  
            'capacity' => 'required|integer',
            'mileage' => 'required|integer',
            'fuel_amount' => 'required|numeric',
            'Last_Service' => 'required|numeric||lt:Next_Service',
            'Next_Service' => 'required|numeric|gt:Last_Service',
            // 'driver_id' => 'nullable|uuid|exists:drivers,driver_id',
            'fuel_type' => 'required|string|In:Electric,Diesel,Benzene',
            'notes' => 'nullable|string',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_category' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'rental_type' => 'nullable|string|max:255',
            'libre' => 'required|file|mimes:pdf,jpg,jpeg',
            'insurance' => 'required|file|mimes:pdf,jpg,jpeg',
        ] );
        // dd($validator);
        
        if ( $validator->fails() ) {
            return redirect()->back()->with('error_message',
            $validator->errors(),
            );
        }
        $filelibre = '';
        $fileinsurance = '';
        if ( $request->hasFile( 'libre' ) ) {
            $file = $request->file( 'libre' );
            $storagePath = storage_path( 'app/public/vehicles' );
            if ( !file_exists( $storagePath ) ) {
                mkdir( $storagePath, 0755, true );
            }

            $filelibre = time() . '_' . $file->getClientOriginalName();
            $file->move( $storagePath, $filelibre );
        }
        if ( $request->hasFile( 'insurance' ) ) {
            $file = $request->file( 'insurance' );

            $storagePath = storage_path( 'app/public/vehicles' );
            if ( !file_exists( $storagePath ) ) {
                mkdir( $storagePath, 0755, true );
            }
            $fileinsurance = time() . '_' . $file->getClientOriginalName();
            $file->move( $storagePath, $fileinsurance );
        }
        $today = \Carbon\Carbon::now();
        $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
        VehiclesModel::create( [
            'vin'=>$request->vin,
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'plate_number' => $request->plate_number,
            'mileage' => $request->mileage,
            'fuel_amount' => $request->fuel_amount,
            'last_service' => $request->Last_Service,
            'next_service' => $request->Next_Service,
            'registered_by' => $user,
            // 'driver_id' => $request->driver,
            'fuel_type' => $request->fuel_type,
            'notes' => $request->Notes,
            'vehicle_type' => $request->vehicle_type,
            'capacity' => $capacity,
            'vehicle_category' => $request->vehicle_category,
            'position' => $request->position,
            'rental_type' => $request->rental_type,
            'libre' => $filelibre,
            'insurance' => $fileinsurance,
            'created_at' => $ethiopianDate
        ] );

        return redirect()->back()->with( 'success_message', 'Vehicle created successfully.' );

    }

    public function show( VehicleInfo $vehicle ) {
        return view( 'vehicles.show', compact( 'vehicle' ) );
    }

    public function edit( VehicleInfo $vehicle ) {
        return view( 'vehicles.edit', compact( 'vehicle' ) );
    }

    public function update(Request $request, $id)
    {
        $user = Auth::id();
        $vehicle = VehiclesModel::findOrFail($id);
    
        // Define validation rules
        $rules = [
            'vin' => 'nullable|string|max:255',
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'plate_number' => 'nullable|regex:/^[A-Z]{2}-\d{1}-\d{5}$/',
            'capacity' => 'nullable|integer',
            'mileage' => 'nullable|integer',
            'fuel_amount' => 'nullable|integer',
            'fuel_type' => 'nullable|string|max:255',
            'last_service' => 'nullable|integer',
            'next_service' => 'nullable|integer',
            'notes' => 'nullable|string|max:255',
            'vehicle_category' => 'nullable|string|max:255',
            'vehicle_type' => 'nullable|string|max:255',
            'rental_type' => 'nullable|string|max:255',
            'inspection_id' => 'nullable|uuid|exists:vehicle_inspections,inspection_id',
            'libre' => 'nullable|file',
            'insurance' => 'nullable|file',
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', $validator->errors());
        }
    
        // Handle file uploads
        $filelibre = $vehicle->libre; // Default to existing file
        $fileinsurance = $vehicle->insurance; // Default to existing file
        $storagePath = storage_path('app/public/vehicles');
    
        if ($request->hasFile('libre')) {
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            $filelibre = time() . '_' . $request->file('libre')->getClientOriginalName();
            $request->file('libre')->move($storagePath, $filelibre);
        }
    
        if ($request->hasFile('insurance')) {
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            $fileinsurance = time() . '_' . $request->file('insurance')->getClientOriginalName();
            $request->file('insurance')->move($storagePath, $fileinsurance);
        }
    
        // Prepare update data dynamically
        $updateData = $request->only([
            'vin',
            'make',
            'model',
            'year',
            'plate_number',
            'capacity',
            'mileage',
            'fuel_amount',
            'fuel_type',
            'last_service',
            'next_service',
            'notes',
            'vehicle_category',
            'vehicle_type',
            'rental_type',
            'inspection_id',
        ]);
    
        // Add dynamic values
        $updateData['libre'] = $filelibre;
        $updateData['insurance'] = $fileinsurance;
        $updateData['registered_by'] = $user;
        $updateData['registration_date'] = $this->dailyKmCalculation->ConvertToEthiopianDate(\Carbon\Carbon::now());
    
        // Remove null fields from the update array
        $updateData = array_filter($updateData, fn($value) => !is_null($value));
    
        // Update the vehicle
        $vehicle->update($updateData);
    
        return redirect()->back()->with('success_message', 'Successfully Updated.');
    }
    

    public function destroy( Request $request ) {
        $validation = Validator::make( $request->all(), [
            'request_id'=>'required|exists:vehicles,vehicle_id',
        ] );
        // Check validation error
        if ( $validation->fails() ) {
            return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
        }
        // Check if the request is that of this users
        $id = $request->input( 'request_id' );
        try {
            $Vehicle = VehiclesModel::findOrFail( $id );
            if ( $Vehicle->driver_id != null ) {
                return redirect()->back()->with('error_message',
                               "You cannot delete this vehilce",
                            );
            }
            $references = [
                ['table' => 'vehicle_inspections', 'column' => 'vehicle_id'],
                ['table' => 'driver_changes', 'column' => 'vehicle_id'],
                ['table' => 'vehicle_requests_parmanently', 'column' => 'vehicle_id'],
                ['table' => 'maintenances', 'column' => 'vehicle_id'],
                ['table' => 'fuelings', 'column' => 'vehicle_id'],
                ['table' => 'Permanent_fuelings', 'column' => 'vehicle_id'],
                ['table' => 'trips', 'column' => 'vehicle_id'],
                ['table' => 'routes', 'column' => 'vehicle_id'],
                ['table' => 'daily_km_calculations', 'column' => 'vehicle_id'],
                ['table' => 'vehicle_requests_temporary', 'column' => 'vehicle_id'],
                ['table' => 'fuel_quatas', 'column' => 'vehicle_id'],
            ];
            // Check each table for references
            foreach ($references as $reference) {
                if (DB::table($reference['table'])->where($reference['column'], $id)->exists()) {
                    return redirect()->back()->with('error_message',
                    "Record is referenced in another table and cannot be deleted",
                            );
                }
            }
            $Vehicle->delete();
            return redirect()->back()->with('success_message',
                'Successfully Deleted.',
            );
        } catch ( Exception $e ) {
            // Handle the case when the vehicle request is not found
            return redirect()->back()->with('error_message',
                               "Sorry, Something went wrong",
                            );
        }
    }
    /**
    * Display the details for a specific vehicle.
    *
    * @param  Vehicle  $vehicle
    * @return \Illuminate\Http\Response
    */

    public function showDetails( VehicleInfo $vehicle ) {
        $details = $vehicle->details()->with( 'user', 'driver' )->get();
        return view( 'vehicles.details.index', compact( 'vehicle', 'details' ) );
    }

    /**
    * Show the form for creating a new vehicle detail.
    *
    * @param  Vehicle  $vehicle
    * @return \Illuminate\Http\Response
    */

    public function createDetail( VehicleInfo $vehicle ) {
        return view( 'vehicles.details.create', compact( 'vehicle' ) );
    }

    /**
    * Store a newly created vehicle detail in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  Vehicle  $vehicle
    * @return \Illuminate\Http\Response
    */

    public function storeDetail( Request $request, VehicleInfo $vehicle ) {
        $validated = $request->validate( [
            'detail' => 'required|string|max:2000',
            'register_by' => 'required|uuid|exists:users,id',
            'date' => 'required|date',
            'mileage' => 'required|integer',
            'driver_id' => 'required|uuid|exists:drivers,driver_id',
        ] );

        $validated[ 'vehicle_id' ] = $vehicle->vehicle_id;

        VehicleDetailModel::create( $validated );
        return redirect()->back()->with('success_message',
        "Vehicle detail created successfully.",
     );
    }

    /**
    * Show the form for editing a specific vehicle detail.
    *
    * @param  Vehicle  $vehicle
    * @param  VehicleDetail  $detail
    * @return \Illuminate\Http\Response
    */

    public function editDetail( VehicleInfo $vehicle, VehicleDetailModel $detail ) {
        return view( 'vehicles.details.edit', compact( 'vehicle', 'detail' ) );
    }

    /**
    * Update the specified vehicle detail in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  Vehicle  $vehicle
    * @param  VehicleDetail  $detail
    * @return \Illuminate\Http\Response
    */

    public function updateDetail( Request $request, VehicleInfo $vehicle, VehicleDetailModel $detail ) {
        $validated = $request->validate( [
            'detail' => 'required|string|max:2000',
            'register_by' => 'required|uuid|exists:users,id',
            'date' => 'required|date',
            'mileage' => 'required|integer',
            'driver_id' => 'required|uuid|exists:drivers,driver_id',
        ] );

        $detail->update( $validated );

        return redirect()->back()->with('success_message',
        "Vehicle detail updated successfully.",
     );    
    }

    /**
    * Remove the specified vehicle detail from storage.
    *
    * @param  Vehicle  $vehicle
    * @param  VehicleDetail  $detail
    * @return \Illuminate\Http\Response
    */

    public function destroyDetail( VehicleInfo $vehicle, VehicleDetailModel $detail ) {
        $detail->delete();
        return redirect()->back()->with('success_message',
        "Vehicle detail deleted successfully.",
     );
       // return redirect()->route( 'vehicles.details.index', $vehicle )->with( 'success', 'Vehicle detail deleted successfully.' );
    }
}
