<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use Illuminate\Http\Request;
use App\Models\DriverChange;
use App\Models\DriverChangeModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DriverChangeController extends Controller
    {
        // Driver change Page
        public function driver_change_page()
            {
                $vehicles = VehiclesModel::all();
                $drivers = DriversModel::all();
                return view('Driver.index',compact('vehicles','drivers'));
            }
        // Store a new Driver Change
        public function store(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                    'new_driver_id' => 'required|uuid|exists:drivers,id',
                    'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
                ]);
                if ($validator->fails()) 
                    {
                        return response()->json(['errors' => $validator->errors()], 422);
                    }
                $vehicle_info = VehiclesModel::findOrFail($request->vehicle_id);
                $former_driver_id = $vehicle_info->driver_id;
                $logged_user = Auth::id();
                $driverChange = DriverChangeModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'old_driver_id' => $former_driver_id,
                    'changed_by' => $logged_user,
                    'new_driver_id' => $request->new_driver_id,
                    'inspection_id' => $request->inspection_id,
                ]);
                $vehicle_info->driver_id = $request->new_driver_id;
                $vehicle_info->save();
                return response()->json($driverChange, 201);
            }
        // Get a specific Driver Change
        public function show(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'request_id' => 'required|uuid|exists:driver_changes,driver_change_id'
                ]);
                if ($validator->fails()) 
                {
                    return response()->json(['success' => false,
                                            'message' => "Warning! You are denied the service"], 422);
                }
                $driverChange = DriverChangeModel::findOrFail($request->request_id);
                return response()->json([
                    'success' => true,
                    'data' => $driverChange,
                ]);
            }
        // Update a Driver Change
        public function update(Request $request)
            {
                    $validator = Validator::make($request->all(), [
                    'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
                    'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                    'new_driver_id' => 'required|uuid|exists:drivers,id',
                    'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
                ]);
                if ($validator->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service',
                        ]);
                    }
                    $driverChange = DriverChangeModel::findOrFail($request->request_id);
                    if($driverChange->driver_accepted == true)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning! You are denied the service',
                                ]);
                            }
                $driverChange->update($request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Driver change successfully updated',
                    'data' =>$driverChange,
                ]);
            }
        // Delete a Driver Change
        public function destroy(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'request_id' => 'required|uuid|exists:driver_changes,driver_change_id'
                ]);
                if ($validator->fails()) 
                {
                    return response()->json(['success' => false,
                                            'message' => "Warning! You are denied the service"], 422);
                }
                $driverChange = DriverChangeModel::findOrFail($request->request_id);
                if($driverChange->driver_accepted == true)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service',
                        ]);
                    }
                if($driverChange->driver_accepted == true)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service',
                        ]);
                    }
                $driverChange->delete();
                return response()->json(['message' => 'Driver change deleted successfully']);
            }
    }
