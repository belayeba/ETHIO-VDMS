<?php

namespace App\Http\Controllers\Vehicle;

    use App\Http\Controllers\Controller;
    use App\Models\Vehicle\VehiclePart;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
    
class VehiclePartsController extends Controller
    {
        // Create a new vehicle part
        public function store(Request $request)
            {
                $rules = [
                    'name' => 'required|string',
                    'notes' => 'nullable|string',
                    //'type' => "required|in:spare_part,norma_part"
                ];
        
                $validator = Validator::make($request->all(), $rules);
        
                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
                }
                $logged_user = Auth::id();
                $vehiclePart = VehiclePart::create([
                    'name' => $request->input('name'),
                    'type' => "spare_part",//$request->input('type'),
                    'created_by' =>$logged_user,
                    'notes' => $request->input('notes'),
                ]);
        
                return response()->json(['status' => 'success', 'data' => $vehiclePart], 201);
            }
    
        // Retrieve a specific vehicle part
        public function show($id)
            {
                $vehiclePart = VehiclePart::find($id);
        
                if (!$vehiclePart) {
                    return response()->json(['status' => 'error', 'message' => 'Vehicle part not found'], 404);
                }
        
                return response()->json(['status' => 'success', 'data' => $vehiclePart]);
            }
    
        // List all vehicle parts
        public function index()
            {
                $vehicleParts = VehiclePart::all();
        
                return view("Vehicle.inspectionpart",compact('vehicleParts'));
            }
    
        // Update a vehicle part
        public function update(Request $request, $id)
            {
                $rules = [
                    'name' => 'required|string',
                    'notes' => 'nullable|string',
                ];
        
                $validator = Validator::make($request->all(), $rules);
        
                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
                }
        
                $vehiclePart = VehiclePart::find($id);
        
                if (!$vehiclePart) {
                    return response()->json(['status' => 'error', 'message' => 'Vehicle part not found'], 404);
                }
        
                $vehiclePart->update([
                    'name' => $request->input('name'),
                    'notes' => $request->input('notes'),
                ]);
        
                return response()->json(['status' => 'success', 'data' => $vehiclePart]);
            }
    
        // Delete a vehicle part
        public function destroy($id)
            {
                $vehiclePart = VehiclePart::find($id);
        
                if (!$vehiclePart) {
                    return response()->json(['status' => 'error', 'message' => 'Vehicle part not found'], 404);
                }
        
                $vehiclePart->delete();
        
                return response()->json(['status' => 'success', 'message' => 'Vehicle part deleted successfully']);
            }
    }
    