<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\GivingBackVehiclePermanently;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class GivingBackPermanentVehicle extends Controller
{
    // Display Request Page
public function displayReturnPermRequestPage()
    {
        $id = Auth::id();
        $Requested = GivingBackVehiclePermanently::where('requested_by',$id)->latest()->get();
        return view("Return.ReturnPermanentVehiclePage",compact('Requested'));
    }
    // Send Vehicle Return Request Parmananently
public function ReturntVehiclePerm(Request $request) 
    {
                   // Validate the request
            $validator = Validator::make($request->all(), [
                'purpose' => 'required|string|max:1000',
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id'
            ]);            
                  // If validation fails, return an error response
            if ($validator->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors(),
                    ]);
                }
            $logged_user = Auth::id();
            $get_permanent_request = VehiclePermanentlyRequestModel::find('request_id');
            if($get_permanent_request->requested_by != $logged_user || $get_permanent_request->status = false)
              {
                return response()->json([
                    'success' => false,
                    'message' => 'Warning! You are denied the service',
                ]);
              }
            try
                {
                    // Create the user
                    GivingBackVehiclePermanently::create([
                        'vehicle_id'=>$get_permanent_request->vehicle_id,
                        'purpose' =>$request->purpose,
                        'requested_by' => $logged_user,
                        'permanent_request' =>$get_permanent_request->vehicle_request_permanent_id,
                    ]);
                    // Success: Record was created
                    // Redirect page to Permananet
                    return response()->json([
                        'success' => true,
                        'message' => 'Request sent successfully.',
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
public function update_return_request(Request $request) 
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|uuid|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id', 
            'purpose' => 'sometimes|required|string|max:1000',

        ]);
        // Check if validation fails
        if ($validator->fails()) 
            {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422); 
            }
        $id = $request->input('request_id');
        try
            {
                $Vehicle_Request = GivingBackVehiclePermanently::find($id); 
                $user_id = Auth::id();
                // Check if the record was found
                if($user_id != $Vehicle_Request->requested_by)
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
                            $perm_request_id = $Vehicle_Request->permanent_request;
                            $get_permanent_request = VehiclePermanentlyRequestModel::find($perm_request_id);
                            if($get_permanent_request->requested_by != $user_id || $get_permanent_request->status = false)
                              {
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Warning! You are denied the service',
                                    ]);
                              }
                                // Update the record with new data
                                $Vehicle_Request->update([
                                    'purpose' => $request->purpose,
                                ]);
                                // Return a success response
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Request updated successfully.',
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
            'request_id'=>'required|uuid|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id',
        ]);
        // Check validation error
        if ($validation->fails()) 
            {
                return response()->json([
                    'success' => false,
                    'message' => "Warning! You are denied the service",
                ]);
            }
        // Check if the request is that of this users
        $id = $request->input('request_id');
        $user_id = Auth::id();
        try 
            {
                $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
                if($Vehicle_Request->requested_by != $user_id || $Vehicle_Request->approved_by)
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
// Vehicle Director Page
public function VehicleDirector_page() 
    {    
            $vehicle_requests = GivingBackVehiclePermanently::latest()->get();
            return view("Return.vehicle_requests", compact('vehicle_requests'));     
    }
// DIRECTOR APPROVE THE REQUESTS
public function VehicleDirectorApproveRequest(Request $request)
    {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|uuid|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id',
            ]);
            // Check validation error
            if ($validation->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' =>"Warning! You are denied the service",
                    ]);
                }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $user_id = Auth::id();
        try
            {
                $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
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
public function Vec_DirectorRejectRequest(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'request_id'=>'required|uuid|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id',
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
                $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
                if($Vehicle_Request->approved_by)
                    {
                      return redirect()->back()->with('error_message',
                                 "Sorry, Something went wrong",
                            );
                    }
                $Vehicle_Request->approved_by = $user_id;
                $Vehicle_Request->reject_reason_vec_director = $reason;
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
// Dispatcher Page
public function Dispatcher_page() 
    {    
            $vehicle_requests = GivingBackVehiclePermanently::whereNotNull('approved_by')
                                ->whereNull('reject_reason_vec_director')
                                ->get();
            return view("Return.vehicle_requests", compact('vehicle_requests'));     
    }
    // VEHICLE DIRECTOR APPROVE THE REQUESTS
public function DispatcherApproveRequest(Request $request)
    {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|uuid|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id',
            ]);
            // Check validation error
            if ($validation->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => "Sorry, You are denied the service",
                    ]);
                }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $user_id = Auth::id();
            $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
            $the_vehicle = VehiclesModel::find($Vehicle_Request->vehicle_id);
            $get_permanent_request = VehiclePermanentlyRequestModel::find($Vehicle_Request->permanent_request );
            if($Vehicle_Request->received_by)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sorry, You are denied the service',
                    ]);
                }
            $todayDateTime = Carbon::now();
            $get_permanent_request->status = false;
            $Vehicle_Request->received_by = $user_id;
            $Vehicle_Request->returned_date = $todayDateTime;
            $the_vehicle->status = true;
            $the_vehicle->save();
            $Vehicle_Request->save();
            $get_permanent_request->save();
            return response()->json([
                'success' => true,
                'message' => 'The Vehicle Successfully Returned',
            ]);
    }
//vehicle Director Reject the request
public function DispatcherRejectRequest(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'request_id'=>'required|uuid|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id',
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
                $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
                if($Vehicle_Request->received_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service',
                        ]);
                    }
                $Vehicle_Request->received_by = $user_id;
                $Vehicle_Request->reject_reason_dispatcher = $reason;
                $Vehicle_Request->save();
                return response()->json([
                    'success' =>true,
                    'message' => 'You have successfully Rejected the Request',
                ]);
            }
        catch(Exception $e)
            {
                return response()->json([
                    'success' =>false,
                    'message' => 'Sorry, Something Went Wrong',
                ]);
            }
    }
}
