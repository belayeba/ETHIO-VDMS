<?php

namespace App\Http\Controllers\vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VehicleTemporaryRequestController extends Controller
{
    // Display Request Page
    public function displayRequestPage()
        {
            $id = Auth::id();
            $Requested = VehicleTemporaryRequestModel::where('requested_by_id',$id)->get();
            return view("Request.ParmanententRequestPage",compact('Requested'));
        }
    // Send Vehicle Request Parmananently
    public function RequestVehiclePerm(Request $request) 
        {
            // Custom validation rule to check equal number of material_name and weight entries
            Validator::extend('equal_count', function ($attribute, $value, $parameters, $validator) use ($request) {
                $countMaterialName = count($request->input('material_name', []));
                $countWeight = count($request->input('weight', []));
                return $countMaterialName === $countWeight;
            }, 'The number of material names and weights must be equal.');
            // Validate the request
            $validator = Validator::make($request->all(), [
                'purpose' => 'required|string|max:255',
                'vehicle_type' => 'required|string',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'return_date' => 'required|date',
                'return_time' => 'required|date_format:H:i',
                'start_location' => 'required|string|max:255',
                'end_location' => 'required|string|max:255',
                'material_name.*' => 'nullable|string|max:255',
                'people_id' => 'nullable|array',
                'people_id.*' => 'exists:users,id',
                'weight.*' => 'nullable|numeric|min:0',
                'material_name' => 'nullable|equal_count',
                'weight' => 'nullable|equal_count',
            ]);
            // If validation fails, return an error response
            if ($validator->fails()) 
                {
                    return response()->json($validator->errors(), 400);
                }
            // Create the user
            $Vehicle_Request = VehicleTemporaryRequestModel::create([
                'purpose' => $request->purpose,
                'vehicle_type' => $request->vehicle_type,
                'start_location' => $request->start_location,
                'end_location'=>$request->end_location,
                'start_date'=>$request->start_date,
                'start_time'=>$request->start_time,
                'return_date'=>$request->return_date,
                'return_time'=>$request->return_time,
            ]);
                // Handle optional material_name and weight fields
                $materialNames = $request->input('material_name', []);
                $weights = $request->input('weight', []);

                foreach ($materialNames as $index => $materialName) 
                    {
                        $Vehicle_Request->materials()->create([
                            'material_name' => $materialName,
                            'weight' => $weights[$index],
                        ]);
                    }
                // Handle optional people IDs
                $peopleIds = $request->input('people', []);

                foreach ($peopleIds as $personId) 
                    {
                        $Vehicle_Request->peoples()->create([
                            'person_id' => $personId,
                        ]);
                    }
                // Return response to user
                return response()->json(['message' => "Request Successfully Done"], 200);
        }
    // User can update Request
    public function update(Request $request) 
        {
               // Custom validation rule to check equal number of material_name and weight entries
                Validator::extend('equal_count', function ($attribute, $value, $parameters, $validator) use ($request) {
                    $countMaterialName = count($request->input('material_name', []));
                    $countWeight = count($request->input('weight', []));
                    return $countMaterialName === $countWeight;
                }, 'The number of material names and weights must be equal.');

                // Validate the request
                $validator = Validator::make($request->all(), [
                    'purpose' => 'required|string|max:255',
                    'vehicle_type' => 'required|string',
                    'start_date' => 'required|date',
                    'start_time' => 'required|date_format:H:i',
                    'return_date' => 'required|date',
                    'return_time' => 'required|date_format:H:i',
                    'start_location' => 'required|string|max:255',
                    'end_location' => 'required|string|max:255',
                    'material_name.*' => 'nullable|string|max:255',
                    'weight.*' => 'nullable|numeric|min:0',
                    'material_name' => 'nullable|equal_count',
                    'weight' => 'nullable|equal_count',
                ]);
            // If validation fails, return an error response
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Create the user
            $Vehicle_Request = VehicleTemporaryRequestModel::create([
                'purpose' => $request->purpose,
                'vehicle_type' => $request->vehicle_type,
                'start_location' => $request->start_location,
                'end_location'=>$request->end_location,
                'start_date'=>$request->start_date,
                'start_time'=>$request->start_time,
                'return_date'=>$request->return_date,
                'return_time'=>$request->return_time,
            ]);

           // Handle optional material_name and weight fields
            $materialNames = $request->input('material_name', []);
            $weights = $request->input('weight', []);

            foreach ($materialNames as $index => $materialName) 
                {
                    $Vehicle_Request->materials()->create([
                        'material_name' => $materialName,
                        'weight' => $weights[$index],
                    ]);
                }
            // Return response to user
            return response()->json(['message' => "Request Successfully Done"], 200);
        }
    // User can delete Request
    public function deleteRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json($validation->errors(), 400);
                    }
                // Check if the request is that of this users
                $id = $request->input('request_id');
                $user_id = Auth::id();
                $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                if($Vehicle_Request->requested_by != $user_id)
                {
                    return response()->json(['Error' => "You are denied the service"], 200);
                }
                $Vehicle_Request->delete();
                return response()->json(['Message' => "Request successfully Deleted"], 400);
        }
    // Directors Page
    public function DirectorApprovalPage()
        {
                $id = Auth::id();
                $directors_data = User::where('id',$id)->get('department_id');
                $dept_id = $directors_data->department_id;
                $Vehicle_Request = VehicleTemporaryRequestModel::where();
                $dept_id = $directors_data->department_id;

                $vehicle_requests = VehicleTemporaryRequestModel::whereHas('requestedBy', function ($query) use ($dept_id) {
                    $query->where('department_id', $dept_id);
                })->get();

                return view("DirectorPage", compact('vehicle_requests'));
        }
    // DIRECTOR APPROVE THE REQUESTS
    public function DirectorApproveRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json($validation->errors(), 201);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $user_id = Auth::id();
                $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                if($Vehicle_Request->approved_by != null)
                    {
                        return response()->json(['Error' => "Warning You are denied the service"], 201);
                    }
                $Vehicle_Request->approved_by = $user_id;
                return response()->json(['Message' => "Request successfully Approved"], 400);
        }
    // Director Reject the request
    public function DirectorRejectRequest(Request $request)
        {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|vehicle_requests_temporary,request_id',
                'reason'=>'required|string|max:1000'
            ]);
                  // Check validation error
            if ($validation->fails()) 
                {
                    return response()->json($validation->errors(), 201);
                }
              // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
            if($Vehicle_Request->approved_by != null)
                {
                    return response()->json(['Error' => "Warning You are denied the service"], 201);
                }
            $Vehicle_Request->approved_by = $user_id;
            $Vehicle_Request->director_reject_reason = $reason;
            return response()->json(['Message' => "Request successfully Approved"], 400);
        }
    // Vehicle Director Page
    public function VehicleDirector() 
        {    
                $id = Auth::id();
                $Vehicle_Request = VehicleTemporaryRequestModel::all();
                return view("VehicleDirectorPage", compact('vehicle_requests'));     
        }
        // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function VehicleDirectorApproveRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                    'start_km'=>'required|integer',
                    'assigned_vehicle_id'=>'required|vehicles,vehicle_id',
                    'km_per_litre'=>'required|integer'
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json($validation->errors(), 201);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $assign_vehicle = $request->input('assigned_vehicle_id');
                $end_km = $request->input('start_km');
                $km_per_litre = $request->input('km_per_liter');
                $user_id = Auth::id();
                $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                if($Vehicle_Request->assigned_by != null)
                    {
                        return response()->json(['Error' => "Warning You are denied the service"], 201);
                    }
                $Vehicle_Request->assigned_by = $user_id;
                $Vehicle_Request->assigned_vehicle_id = $assign_vehicle;
                $Vehicle_Request->start_km = $end_km;
                $Vehicle_Request->km_per_liter = $km_per_litre;
                $Vehicle_Request->save();
                return response()->json(['Message' => "Request successfully Approved"], 400);
        }
        // Vehicle Director Fill start km
    public function VehicleDirectorFillstartKm(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                    'start_km'=>'required|integer',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json($validation->errors(), 201);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $start_km = $request->input('start_km');
                $user_id = Auth::id();
                $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                if($Vehicle_Request->assigned_by != null)
                    {
                        return response()->json(['Error' => "Warning You are denied the service"], 201);
                    }
                $Vehicle_Request->assigned_by = $user_id;
                $Vehicle_Request->start_km = $start_km;
                $Vehicle_Request->save();
                return response()->json(['Message' => "Information Filled Successfully"], 400);
        }
    //vehicle Director Reject the request
    public function VehicleDirectorRejectRequest(Request $request)
        {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|vehicle_requests_temporary,request_id',
                'reason'=>'required|string|max:1000'
            ]);
                  // Check validation error
            if ($validation->fails()) 
                {
                    return response()->json($validation->errors(), 201);
                }
              // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
            if($Vehicle_Request->assigned_by != null)
                {
                    return response()->json(['Error' => "Warning You are denied the service"], 201);
                }
            $Vehicle_Request->assigned_by = $user_id;
            $Vehicle_Request->vec_director_reject_reason = $reason;
            $Vehicle_Request->save();
            return response()->json(['Message' => "Request successfully Approved"], 400);
        }
    // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function Returning_temporary_vehicle(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                    'end_km'=>'required|number'
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json($validation->errors(), 201);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $end_km = $request->input('end_km');
                $user_id = Auth::id();
                $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                if($Vehicle_Request->assigned_by != null)
                    {
                        return response()->json(['Error' => "Warning You are denied the service"], 201);
                    }
                $Vehicle_Request->assigned_by = $user_id;
                $Vehicle_Request->end_km = $end_km;
                $Vehicle_Request->save();
                return response()->json(['Message' => "Request successfully Approved"], 400);
        }
}
