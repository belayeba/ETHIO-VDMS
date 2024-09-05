<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use Illuminate\Http\Request;
use App\Models\DriverChange;
use App\Models\DriverChangeModel;
use App\Models\Vehicle\VehiclesModel;
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
                $request->validate([
                    'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                    'new_driver_id' => 'required|uuid|exists:users,id',
                    'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
                ]);

                $driverChange = DriverChangeModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'new_driver_id' => $request->new_driver_id,
                    'inspection_id' => $request->inspection_id,
                ]);

                return response()->json($driverChange, 201);
            }
        // Get a specific Driver Change
        public function show($id)
            {
                $driverChange = DriverChangeModel::findOrFail($id);
                return response()->json([
                    'success' => true,
                    'message' => 'Warning! You are denied the service',
                    'data' => $driverChange,
                ]);
            }
        // Update a Driver Change
        public function update(Request $request, $id)
            {
                $driverChange = DriverChangeModel::findOrFail($id);
                if($driverChange->driver_accepted == true)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service',
                    ]);
                }
                $request->validate([
                    'vehicle_id' => 'uuid|exists:vehicles,vehicle_id',
                    'new_driver_id' => 'uuid|exists:users,id',
                    'old_driver_id' => 'uuid|exists:users,id',
                    'inspection_id' => 'uuid|exists:vehicle_inspections,inspection_id',
                ]);
                $driverChange->update($request->all());

                return response()->json([
                    'success' => true,
                    'message' => 'Driver change successfully updated',
                    'data' =>$driverChange,
                ]);
            }
        // Delete a Driver Change
        public function destroy($id)
            {
                $driverChange = DriverChangeModel::findOrFail($id);
                $driverChange->delete();

                return response()->json(['message' => 'Driver change deleted successfully']);
            }
    }
