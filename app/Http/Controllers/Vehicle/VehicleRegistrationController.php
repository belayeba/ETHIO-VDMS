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

    public function create() {
        return view( 'vehicles.create' );
    }

    public function store( Request $request ) {
        // dd($request->mileage);
        $user = Auth::id();
        $capacity = (int) $request->capacity;

        $validator = Validator::make( $request->all(), [
            'vin' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'plate_number' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'mileage' => 'required|integer',
            'fuel_amount' => 'required|numeric',
            'last_service' => 'nullable|numeric',
            'next_service' => 'nullable|numeric',
            'registered_by' => 'nullable|uuid|exists:users,id',
            'driver_id' => 'nullable|uuid|exists:drivers,driver_id',
            'fuel_type' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_category' => 'required|string|max:255',
            'libre' => 'nullable|file|mimes:pdf,jpg,jpeg',
            'insurance' => 'nullable|file|mimes:pdf,jpg,jpeg',
        ] );
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
        $today = \Carbon\Carbon::today();
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
            'driver_id' => $request->driver,
            'fuel_type' => $request->fuel_type,
            'notes' => $request->Notes,
            'vehicle_type' => $request->vehicle_type,
            'capacity' => $capacity,
            'vehicle_category' => $request->vehicle_category,
            'libre' => $filelibre,
            'insurance' => $fileinsurance,
            'created_at' => $ethiopianDate
        ] );

        // return response()->json( [
        //     'success' => true,
        //     'message' => 'Vehicle created successfully.',
        // ] );
        return redirect()->back()->with( 'success_message', 'Vehicle created successfully.' );

    }

    public function show( VehicleInfo $vehicle ) {
        return view( 'vehicles.show', compact( 'vehicle' ) );
    }

    public function edit( VehicleInfo $vehicle ) {
        return view( 'vehicles.edit', compact( 'vehicle' ) );
    }

    public function update( Request $request, $id ) {
        $user = Auth::id();
        // dd( $request->fuel_amount );
        $vehicle = VehiclesModel::findOrFail( $id );
        // dd( $vehicle );
        // Validate the request
        $validator = Validator::make( $request->all(), [
            'vin' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.date( 'Y' ),
            'plate_number' => 'required|regex:/^[A-Z]{2}-\d{1}-\d{5}$/',
            'capacity' => 'required|integer',
            'mileage' => 'required|integer',
            'fuel_amount' => 'required|integer',
            'fuel_type' => 'required|string|max:255',
            'last_service' => 'required|integer',
            'next_service' => 'required|integer',
            'notes' => 'nullable|string|max:255',
            'vehicle_category' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'inspection_id' => 'nullable|uuid|exists:vehicle_inspections,inspection_id',
            'libre' => 'nullable|file',
            'insurance' => 'nullable|file',
        ] );
        // dd( $validator );
        if ( $validator->fails() ) {
            return redirect()->back()->with('error_message',
                               $validator->errors(),
                            );
        }
        // Handle file uploads if necessary
        if ( $request->hasFile( 'libre' ) ) {
            // Store file and set the file path
            $vehicle->libre = $request->file( 'libre' )->store( 'libres' );
        }

        if ( $request->hasFile( 'insurance' ) ) {
            // Store file and set the file path
            $vehicle->insurance = $request->file( 'insurance' )->store( 'insurances' );
        }
        $filelibre = '';
        $fileinsurance = '';
        $status = true;

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
                    "Record is referenced in another table and cannot be updated",
                            );
                }
            }
        // Update the vehicle with the new data
        $today = \Carbon\Carbon::today();
        $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
        VehiclesModel::find( $id )->update( [
            'vin'=>$request->vin,
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'plate_number' => $request->plate_number,
            'registration_date' => $ethiopianDate,
            'mileage' => $request->mileage,
            'fuel_amount' => $request->fuel_amount,
            'last_service' => $request->Last_Service,
            'capacity' => $request->capacity,
            'next_service' => $request->Next_Service,
            'registered_by' => $user,
            'fuel_type' => $request->fuel_type,
            'inspection_id' => $request->inspection_id,
            'status' => $status,
            'notes' => $request->Notes,
            'vehicle_type' => $request->vehicle_type,
            'vehicle_category' => $request->vehicle_category,
            'libre' => $filelibre,
            'insurance' => $fileinsurance,
        ] );

        return redirect()->back()->with( 'success', 'Vehicle updated successfully.' );
    }

    public function destroy( Request $request ) {
        $validation = Validator::make( $request->all(), [
            'request_id'=>'required|exists:vehicles,vehicle_id',
        ] );
        // Check validation error
        if ( $validation->fails() ) {
            return response()->json( [
                'success' => false,
                'message' => $validation->errors(),
            ] );
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
            return redirect()->back()->with( 'success', 'Vehicle Deleted successfully.' );
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
