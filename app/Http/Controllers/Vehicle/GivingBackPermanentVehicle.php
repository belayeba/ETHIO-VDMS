<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\GivingBackVehiclePermanently;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;


class GivingBackPermanentVehicle extends Controller
{
    // Display Request Page
public function displayReturnPermRequestPage()
    {
        $id = Auth::id();
        $Requested = VehiclePermanentlyRequestModel::where('requested_by',$id)->latest()->get();
        return view("Return.GivingParmanententVehiclePage",compact('Requested'));
    }
    // Send Vehicle Return Request Parmananently
public function ReturntVehiclePerm(Request $request) 
    {dd($request);
            // Validate the request
            $validator = Validator::make($request->all(), [
                'purpose' => 'required|string|max:1000',
                'permanen' => 'required|uuid|exists:vehicles,vehicle_id'
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
                    GivingBackVehiclePermanently::create([
                        'vehicle_id'=>$request->vehicle,
                        'purpose' =>$request->purpose,
                        'requested_by' => $id,
                    ]);
                    // Success: Record was created
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
            'vehicle' => 'sometimes|required|uuid|exists:vehicles,vehicle_id'
        ]);
        // Check if validation fails
        if ($validator->fails()) 
            {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422); // 422 Unprocessable Entity
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
                                // Update the record with new data
                                $Vehicle_Request->update([
                                    'purpose' => $request->purpose,
                                    'vehicle_id' => $request->vehicle,
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
            // $directors_data = User::where('id',$id)->get('department_id');
            // $dept_id = $directors_data->department_id;

            $vehicle_requests = GivingBackVehiclePermanently::
            // whereHas('requestedBy', function ($query) use ($dept_id) {
            //     $query->where('department_id', $dept_id);
            // })
            get();

            return view("Return.DirectorPage", compact('vehicle_requests'));
    }
// DIRECTOR APPROVE THE REQUESTS
public function DirectorApproveRequest(Request $request)
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
public function DirectorRejectRequest(Request $request)
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
                $Vehicle_Request->reject_reason_director = $reason;
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
            $vehicle_requests = GivingBackVehiclePermanently::all();
            return view("Return.vehicle_requests", compact('vehicle_requests'));     
    }
    // VEHICLE DIRECTOR APPROVE THE REQUESTS
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
                        'message' => "Sorry, You are denied the service",
                    ]);
                }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $user_id = Auth::id();
            $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);

            if($Vehicle_Request->received_by)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sorry, You are denied the service',
                    ]);
                }
            $Vehicle_Request->received_by = $user_id;
            $Vehicle_Request->save();
            return response()->json([
                'success' => true,
                'message' => 'The Vehicle Successfully Returned',
            ]);
    }
//vehicle Director Reject the request
public function VehicleDirectorRejectRequest(Request $request)
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
                $Vehicle_Request->reject_reason_vec_dire = $reason;
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
