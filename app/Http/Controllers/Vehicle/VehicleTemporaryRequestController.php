<?php

namespace App\Http\Controllers\vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VehicleTemporaryRequestController extends Controller
{
    // Display Request Page
    public function displayRequestPage()
        {
            $id = Auth::id();
            $users = user::get();
            // $Requested = VehicleTemporaryRequestModel::where('requested_by_id',$id)->get();
            return view("Request.TemporaryRequestPage",compact('users'));
        }
    // Send Vehicle Request Temporary
    public function RequestVehicleTemp(Request $request) 
        {
            // dd($request);
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
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors(),
                    ]);
                }
                try {
                    DB::beginTransaction();
                    $id = Auth::id();
                    // dd($request->return_time);
                    // Create the vehicle request
                    $Vehicle_Request = VehicleTemporaryRequestModel::create([
                        'purpose' => $request->purpose,
                        'vehicle_type' => $request->vehicle_type,
                        'requested_by'=> $id,
                        'start_location' => $request->start_location,
                        'end_location' => $request->end_location,
                        'start_date' => $request->start_date,
                        'start_time' => $request->start_time,
                        'return_date' => $request->return_date ?? '07/08/2024',
                        'return_time' => $request->return_time ?? '08:00' ,
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
                
                    foreach ($peopleIds as $personId) {
                        $Vehicle_Request->peoples()->create([
                            'person_id' => $personId,
                        ]);
                    }
                
                    // Commit the transaction
                    DB::commit();
                
                    // Return response to user
                    return response()->json([
                        'success' => true,
                        'message' => 'You successfully requested a vehicle',
                    ]);
                
                } catch (Exception $e) {
                    // Rollback the transaction
                    DB::rollBack();
                
                    // Log the exception
                    Log::error('Error creating vehicle request: ' . $e->getMessage());
                
                    // Return error response to user
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred while requesting the vehicle: ' . $e->getMessage(),
                    ], 500);
                }
        }
    // User can update Request
     public function update(Request $request) 
        {
             // Validate the request
             $validator = Validator::make($request->all(), [
                 'request_id' => 'required|uuid|exists:users,id', // Check if UUID exists in the 'users' table
                 'purpose' => 'sometimes|string|max:255',
                 'vehicle_type' => 'sometimes|string',
                 'start_date' => 'sometimes|date',
                 'start_time' => 'sometimes|date_format:H:i',
                 'return_date' => 'sometimes|date',
                 'return_time' => 'sometimes|date_format:H:i',
                 'start_location' => 'sometimes|string|max:255',
                 'end_location' => 'sometimes|string|max:255',
             ]);
            // If validation fails, return an error response
            if ($validator->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors(),
                    ]);
                }
            $id = $request->input('request_id');
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id); 
                    $user_id = Auth::id();
                    if($user_id != $Vehicle_Request->requested_by_id)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.'
                            ]);
                        }
                    if($Vehicle_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.'
                            ]);
                        }
                    else
                        {
                            // Update the record with new data
                            $Vehicle_Request->update([
                                'purpose' => $request->purpose,
                                'vehicle_type' => $request->vehicle_type,
                                'start_location' => $request->start_location,
                                'end_location'=>$request->end_location,
                                'start_date'=>$request->start_date,
                                'start_time'=>$request->start_time,
                                'return_date'=>$request->return_date,
                                'return_time'=>$request->return_time,
                            ]);

                            // Return a success response
                            return response()->json([
                                'success' => true,
                                'message' => 'Vehicle request updated successfully.',
                            ]);
                        }
                }
                catch (Exception $e) {
                    // Handle the case when the vehicle request is not found
                    return response()->json([
                        'success' => false,
                        'message' => 'Sorry, Something went wrong',
                    ]);
                }
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
                        return response()->json([
                            'success' => false,
                            'message' => $validation->errors(),
                        ]);
                    }
                // Check if the request is that of this users
                $id = $request->input('request_id');
                $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    if($Vehicle_Request->requested_by != $user_id)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.',
                            ]);
                        }
                    if($Vehicle_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'You are denied the service.',
                            ]);
                        }
                    $Vehicle_Request->delete();
                    return response()->json([
                        'success' => true,
                        'message' => 'Request deleted successfully.',
                    ]);
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
    // Directors Page
    public function DirectorApprovalPage()
        {
                $id = Auth::id();
                $directors_data = User::where('id',$id)->get('department_id');
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
                        return response()->json([
                            'success' => true,
                            'message' => $validation->errors(),
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    if($Vehicle_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service',
                            ]);
                        }
                    $Vehicle_Request->approved_by = $user_id;
                    return response()->json([
                        'success' => true,
                        'message' => 'The requests approved successfully',
                    ]);
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
                    return response()->json([
                        'success' => false,
                        'message' => $validation->errors(),
                    ]);
                }
              // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    if($Vehicle_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service',
                            ]);
                        }
                    $Vehicle_Request->approved_by = $user_id;
                    $Vehicle_Request->director_reject_reason = $reason;
                    return response()->json([
                        'success' => true,
                        'message' => 'The request Rejected Successfully',
                    ]);
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
    // Vehicle Director Page
    public function VehicleDirectorPage() 
        {    
                $id = Auth::id();
                $vehicle_requests = VehicleTemporaryRequestModel::all();
                return view("VehicleDirectorPage", compact('vehicle_requests'));     
        }
        // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function VehicleDirectorApproveRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                    'assigned_vehicle_id'=>'required|vehicles,vehicle_id',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => $validation->errors(),
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $assign_vehicle = $request->input('assigned_vehicle_id');
                $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    if($Vehicle_Request->assigned_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning!, You are denied the service',
                            ]);
                        }
                    $Vehicle_Request->assigned_by = $user_id;
                    $Vehicle_Request->assigned_vehicle_id = $assign_vehicle;
                    $Vehicle_Request->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'You are successfully Approved the request',
                    ]);
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
        // Vehicle Director Fill start km
    public function VehicleDirectorFillstartKm(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|vehicle_requests_temporary,request_id',
                    'start_km'=>'required|integer',
                    'km_per_litre','required|integer'
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json($validation->errors(), 201);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $start_km = $request->input('start_km');
                $km_per_litre = $request->input('km_per_litre');
                $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    $Vehicle_Request->assigned_by = $user_id;
                    $Vehicle_Request->start_km = $start_km;
                    $Vehicle_Request->km_per_litre = $km_per_litre;
                    $Vehicle_Request->save();
                    return response()->json([
                        'success' => false,
                        'message' => 'You have filled the information succefully',
                    ]);
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
                    return response()->json([
                        'success' => false,
                        'message' => 'Sorry, Something went wrong',
                    ]);
                }
              // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    if($Vehicle_Request->assigned_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Sorry, Something went wrong',
                            ]);
                        }        
                    $Vehicle_Request->assigned_by = $user_id;
                    $Vehicle_Request->vec_director_reject_reason = $reason;
                    $Vehicle_Request->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'The Request Rejected Successfully',
                    ]);
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
                        return response()->json([
                            'success' => false,
                            'message' => $validation->errors(),
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $end_km = $request->input('end_km');
                $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                    $Vehicle_Request->assigned_by = $user_id;
                    $Vehicle_Request->end_km = $end_km;
                    $Vehicle_Request->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Return Successfully Done!',
                    ]);                
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
}
