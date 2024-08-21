<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleParmanentlyRequestController extends Controller
{
        // Display Request Page
    public function displayPermRequestPage()
        {
            $id = Auth::id();
            $Requested = VehiclePermanentlyRequestModel::where('requested_by_id',$id)->with('vehicle')->latest()->get();
            return view("Request.ParmanententRequestPage",compact('Requested'));
        }
        // Send Vehicle Request Parmananently
    public function RequestVehiclePerm(Request $request) 
        {
                // Validate the request
                $validator = Validator::make($request->all(), [
                    'purpose' => 'required|string|max:255',
                    'position_letter' => 'required|file|mimes:pdf,jpeg,png,jpg', // For PDF and common image types
                ]);            
                // If validation fails, return an error response
                if ($validator->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => $validator->errors(),
                        ]);
                    }
                $id = Auth::id();
                try
                    {
                        // Create the user
                        VehiclePermanentlyRequestModel::create([
                            'requested_by'=>$id,
                            'purpose' => $request->purpose,
                            'position_letter' => $request->position_letter,
                        ]);
                        // Success: Record was created
                        return response()->json([
                            'success' => true,
                            'message' => 'Vehicle request created successfully.',
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
    public function update_perm_request(Request $request) 
        {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'request_id' => 'required|uuid|exists:users,id', // Check if UUID exists in the 'users' table
                'purpose' => 'sometimes|string|max:255',
                'position_letter' => 'sometimes|file|mimes:pdf,jpeg,png,jpg|max:2048', // 2MB max size for file
            ]);
            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422); // 422 Unprocessable Entity
            }
            $id = $request->input('request_id');
            try
                {
                    $Vehicle_Request = VehiclePermanentlyRequestModel::find($id); 
                    $user_id = Auth::id();
                    // Check if the record was found
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
                                        'position_letter' => $request->position_letter,
                                    ]);

                                    // Return a success response
                                    return response()->json([
                                        'success' => true,
                                        'message' => 'Vehicle request updated successfully.',
                                    ]);
                            }
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
                    $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
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
                                'message' => 'Warning! You are denied the service.',
                            ]);
                        }
                    $Vehicle_Request->delete();
                    return response()->json([
                        'success' => true,
                        'message' => 'Request Successfully deleted',
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

                $vehicle_requests = VehiclePermanentlyRequestModel::whereHas('requestedBy', function ($query) use ($dept_id) {
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
                            'success' => false,
                            'message' => $validation->errors(),
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
                    if($Vehicle_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning!, You are denied the service',
                            ]);
                        }
                    $Vehicle_Request->approved_by = $user_id;
                    $Vehicle_Request->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'You approved the request successfully',
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
                        'message' => 'Sorry, Something went wrong',
                    ]);
                }
              // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            try
                {
                    $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
                    if($Vehicle_Request->approved_by != null)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Sorry, Something went wrong',
                            ]);
                        }
                    $Vehicle_Request->approved_by = $user_id;
                    $Vehicle_Request->director_reject_reason = $reason;
                    $Vehicle_Request->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'You are successfully Rejected the Request',
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
    public function VehicleDirector_page() 
        {    
                $id = Auth::id();
                $Vehicle_Request = VehiclePermanentlyRequestModel::all();
                return view("vehicle_requests", compact('vehicle_requests'));     
        }
        // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function VehicleDirectorApproveRequest(Request $request)
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
                // Check if it is not approved before
                $id = $request->input('request_id');
                $user_id = Auth::id();
                $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
                if($Vehicle_Request->given_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sorry, You are denied the service',
                        ]);
                    }
                $Vehicle_Request->given_by = $user_id;
                $Vehicle_Request->save();
                return response()->json([
                    'success' => true,
                    'message' => 'The Request is successfully Approved',
                ]);
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
            $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
            if($Vehicle_Request->assigned_by)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service',
                    ]);
                }
            $Vehicle_Request->given_by = $user_id;
            $Vehicle_Request->vec_director_reject_reason = $reason;
            $Vehicle_Request->save();
            return response()->json([
                'success' =>true,
                'message' => 'You have successfully Rejected the Request',
            ]);
        }
}
