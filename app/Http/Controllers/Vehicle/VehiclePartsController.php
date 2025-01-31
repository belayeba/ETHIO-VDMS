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
                    'name' => 'required|string|unique:vehicle_parts,name',
                    'notes' => 'nullable|string',
                    'type' => "required|in:spare_part,normal_part"
                ];
        
                $validator = Validator::make($request->all(), $rules);
        
                if ($validator->fails()) {
                    return redirect()->back()->with('error_message',
                    $validator->errors(),
                    );
                }
                $logged_user = Auth::id();
                $vehiclePart = VehiclePart::create([
                    'name' => $request->input('name'),
                    'type' => $request->input('type'),
                    'created_by' =>$logged_user,
                    'notes' => $request->input('notes'),
                ]);
                return redirect()->back()->with('success_message',"Vehicle Part Successfully Registered",);
            }
    
        // Retrieve a specific vehicle part
        public function show($id)
            {
                $vehiclePart = VehiclePart::find($id);
        
                if (!$vehiclePart) {
                    return redirect()->back()->with('error_message','Vehicle Part not found',);
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
                    return redirect()->back()->with('error_message','All fields are required',);
                }
        
                $vehiclePart = VehiclePart::find($id);
        
                if (!$vehiclePart) {
                    return redirect()->back()->with('error_message','Vehicle Part not found',);
                }
        
                $vehiclePart->update([
                    'name' => $request->input('name'),
                    'notes' => $request->input('notes'),
                ]);
                return redirect()->back()->with('success_message',"Vehicle Part Successfully Updated",);
            }
    
        // Delete a vehicle part
        public function destroy($id)
            {
                $vehiclePart = VehiclePart::find($id);
        
                if (!$vehiclePart) {
                    return redirect()->back()->with('error_message','Vehicle part not found',);
                }
        
                $vehiclePart->delete();
                return redirect()->back()->with('success_message',
                'Successfully Deleted.',
            );
            }
    }
    