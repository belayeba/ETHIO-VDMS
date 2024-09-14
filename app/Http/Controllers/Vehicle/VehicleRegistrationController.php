<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
// use App\Models\Vehicle\VehicleModel;
use App\Models\Vehicle\VehicleInfo;
use App\Models\VehicleDetailModel;
use App\Models\Vehicle\VehiclesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleRegistrationController extends Controller
{
    // public function index()
    // {
    //     // dd("It is vehicle index baby ;)");
    //     $vehicles = VehicleDetailModel::with(['user', 'driver', 'details'])->get();

    //     return view('Vehicle_Registration.show', compact('vehicles'));
    // }
    public function index()
        {

            $vehicle = VehiclesModel::paginate(6);
            return view('Vehicle_Registration.show',compact('vehicle'));
        }
    public function create()
        {
            return view('vehicles.create');
        }

    public function store(Request $request)
        {
        // dd($request)
            $user = Auth::id();
            // dd($request);
            $validator = Validator::make($request->all(),[
                'vin' => 'required|string|max:255',
                'make' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer',
                'plate_number' => 'required|string|max:255',
                'registration_date' => 'required|date',
                'mileage' => 'required|integer',
                'fuel_amount' => 'required|numeric',
                'last_service' => 'nullable|date',
                'next_service' => 'nullable|date',
                'registered_by' => 'nullable|uuid|exists:users,id',
                'driver_id' => 'nullable|uuid|exists:drivers,driver_id',
                'fuel_type' => 'required|string|max:255',
                'inspection_id' => 'nullable|uuid|exists:vehicle_inspections,inspection_id',
                'notes' => 'nullable|string',
                'vehicle_type' => 'required|string|max:255',
                'vehicle_category' => 'required|string|max:255',
                'libre' => 'nullable|file|mimes:pdf,jpg,jpeg',
                'insurance' => 'nullable|file|mimes:pdf,jpg,jpeg',
            ]);
                if ($validator->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => $validator->errors(),
                        ]);
                    }
                $filelibre='';
                $fileinsurance='';

                if ($request->hasFile('libre')) {
                    $file = $request->file('libre');
                    $storagePath= storage_path('app/public/vehicles');
                    if(!file_exists($storagePath)){
                        mkdir($storagePath,0755,true);
                    }

                    $filelibre = time() . '_' . $file->getClientOriginalName();
                    $file->move($storagePath, $filelibre);
                }
                if ($request->hasFile('insurance')) {
                    $file = $request->file('insurance');

                    $storagePath= storage_path('app/public/vehicles');
                    if(!file_exists($storagePath)){
                        mkdir($storagePath,0755,true);
                    }
                    $fileinsurance = time() . '_' . $file->getClientOriginalName();
                    $file->move($storagePath, $fileinsurance);
                }
                VehiclesModel::create([
                    'vin'=>$request->vin,
                    'make' => $request->make,
                    'model' => $request->model,
                    'year' => $request->year,
                    'plate_number' => $request->plate_number,
                    'registration_date' => $request->registration_date,
                    'mileage' => $request->mileage,
                    'fuel_amount' => $request->fuel_amount,
                    'last_service' => $request->Last_Service,
                    'next_service' => $request->Next_Service,
                    'registered_by' => $user,
                    'driver_id' => $request->driver_id,
                    'fuel_type' => $request->fuel_type,
                    'notes' => $request->Notes,
                    'vehicle_type' => $request->vehicle_type,
                    'inspection_id' => $request->inspection_id,
                    'vehicle_category' => $request->vehicle_category,
                    'libre' => $filelibre,
                    'insurance' => $fileinsurance,
                ]);

                // return response()->json([
                //     'success' => true,
                //     'message' => 'Vehicle created successfully.',
                // ]);
                return redirect()->back()->with('success', 'Vehicle created successfully.');
        
        }

    public function show(VehicleInfo $vehicle)
        {
            return view('vehicles.show', compact('vehicle'));
        }

    public function edit(VehicleInfo $vehicle)
        {
            return view('vehicles.edit', compact('vehicle'));
        }

    public function update(Request $request, $id)
        {
            $user = Auth::id();
            // dd($request->fuel_amount);
            $vehicle = VehiclesModel::findOrFail($id);
            // dd($vehicle);
            // Validate the request
            $validator = Validator::make($request->all(),[
                'vin' => 'required|string|max:255',
                'make' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:'.date('Y'),
                'plate_number' => 'required|regex:/^[A-Z]{2}-\d{1}-\d{5}$/',
                'registration_date' => 'required|date',
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
            ]);
            // dd($validator);
            if ($validator->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors(),
                    ]);
                }
            // Handle file uploads if necessary
            if ($request->hasFile('libre')) 
                {
                    // Store file and set the file path
                    $vehicle->libre = $request->file('libre')->store('libres');
                }
        
            if ($request->hasFile('insurance')) 
                {
                    // Store file and set the file path
                    $vehicle->insurance = $request->file('insurance')->store('insurances');
                }
            $filelibre='';
            $fileinsurance='';
            $status = 'active';

            if ($request->hasFile('libre')) {
                $file = $request->file('libre');
                $storagePath= storage_path('app/public/vehicles');
                if(!file_exists($storagePath)){
                    mkdir($storagePath,0755,true);
                }

                $filelibre = time() . '_' . $file->getClientOriginalName();
                $file->move($storagePath, $filelibre);
            }
            if ($request->hasFile('insurance')) {
                $file = $request->file('insurance');

                $storagePath= storage_path('app/public/vehicles');
                if(!file_exists($storagePath)){
                    mkdir($storagePath,0755,true);
                }

                $fileinsurance = time() . '_' . $file->getClientOriginalName();
                $file->move($storagePath, $fileinsurance);
            }
        
            // Update the vehicle with the new data
            VehiclesModel::find($id)->update([
                'vin'=>$request->vin,
                'make' => $request->make,
                'model' => $request->model,
                'year' => $request->year,
                'plate_number' => $request->plate_number,
                'registration_date' => $request->registration_date,
                'mileage' => $request->mileage,
                'fuel_amount' => $request->fuel_amount,
                'last_service' => $request->Last_Service,
                'next_service' => $request->Next_Service,
                'registered_by' => $user,
                'driver_id' => $request->driver_id,
                'fuel_type' => $request->fuel_type,
                'inspection_id' => $request->inspection_id,
                'status' => $status,
                'notes' => $request->Notes,
                'vehicle_type' => $request->vehicle_type,
                'vehicle_category' => $request->vehicle_category,
                'libre' => $filelibre,
                'insurance' => $fileinsurance,
            ]);

            return redirect()->back()->with('success', 'Vehicle updated successfully.');
        }
    public function destroy(Request $request)
        {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|exists:vehicles,vehicle_id',
            ]);
            // Check validation error
            if ($validation->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => $validation->errors(),
                    ]);
                }
                // Check if the request is that of this users
                $id = $request->input('request_id');
                $user_id=Auth::id();
                try 
                    {
                        $Vehicle = VehiclesModel::findOrFail($id);
                        if($Vehicle->registered_by != $user_id)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning! You are denied the service.',
                                ]);
                            }
                        if($Vehicle->driver_id !== null)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning! You are denied the service.',
                                ]);
                            }
                        $Vehicle->delete();
                        return redirect()->back()->with('success', 'Vehicle Deleted successfully.');
                        // return response()->json([
                        //     'success' => true,
                        //     'message' => 'Request Successfully deleted',
                        // ]);
                    } 
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                        return response()->json([
                            'success' => false,
                            'message' => 'Sorry, Something went wrong',
                        ]);
                    }
        }
    /**
     * Display the details for a specific vehicle.
     *
     * @param  Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function showDetails(VehicleInfo $vehicle)
        {
            $details = $vehicle->details()->with('user', 'driver')->get();
            return view('vehicles.details.index', compact('vehicle', 'details'));
        }

    /**
     * Show the form for creating a new vehicle detail.
     *
     * @param  Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function createDetail(VehicleInfo $vehicle)
        {
            return view('vehicles.details.create', compact('vehicle'));
        }

    /**
     * Store a newly created vehicle detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request, VehicleInfo $vehicle)
        {
            $validated = $request->validate([
                'detail' => 'required|string|max:2000',
                'register_by' => 'required|uuid|exists:users,id',
                'date' => 'required|date',
                'mileage' => 'required|integer',
                'driver_id' => 'required|uuid|exists:drivers,driver_id',
            ]);

            $validated['vehicle_id'] = $vehicle->vehicle_id;

            VehicleDetailModel::create($validated);

            return redirect()->route('vehicles.details.index', $vehicle)->with('success', 'Vehicle detail created successfully.');
        }

    /**
     * Show the form for editing a specific vehicle detail.
     *
     * @param  Vehicle  $vehicle
     * @param  VehicleDetail  $detail
     * @return \Illuminate\Http\Response
     */
    public function editDetail(VehicleInfo $vehicle, VehicleDetailModel $detail)
        {
            return view('vehicles.details.edit', compact('vehicle', 'detail'));
        }

    /**
     * Update the specified vehicle detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Vehicle  $vehicle
     * @param  VehicleDetail  $detail
     * @return \Illuminate\Http\Response
     */
    public function updateDetail(Request $request, VehicleInfo $vehicle, VehicleDetailModel $detail)
        {
            $validated = $request->validate([
                'detail' => 'required|string|max:2000',
                'register_by' => 'required|uuid|exists:users,id',
                'date' => 'required|date',
                'mileage' => 'required|integer',
                'driver_id' => 'required|uuid|exists:drivers,driver_id',
            ]);

            $detail->update($validated);

            return redirect()->route('vehicles.details.index', $vehicle)->with('success', 'Vehicle detail updated successfully.');
        }

    /**
     * Remove the specified vehicle detail from storage.
     *
     * @param  Vehicle  $vehicle
     * @param  VehicleDetail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroyDetail(VehicleInfo $vehicle, VehicleDetailModel $detail)
        {
            $detail->delete();

            return redirect()->route('vehicles.details.index', $vehicle)->with('success', 'Vehicle detail deleted successfully.');
        }
}
