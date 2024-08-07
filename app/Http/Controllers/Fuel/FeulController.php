<?php

namespace App\Http\Controllers\Fuel;

use App\Http\Controllers\Controller;
use App\Models\FuelsModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeulController extends Controller
{
    // Display Request Page
public function displayFuelRequestPage()
    {
        $id = Auth::id();
        $Requested = FuelsModel::where('driver_id',$id)->get();
        return view("Request.FuelRequstPage",compact('Requested'));
    }
    // Fuel Request (Post Data)
public function RequestFuel(Request $request) 
    {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'fuel_amount' => 'required|number',
                'vehicle'=>'required|uuid|exists:vehicles,vehicle_id'
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
                    FuelsModel::create([
                        'driver_id'=>$id,
                        'vehicle_id' => $request->vehicle,
                        'fuel_amount' => $request->fuel_amount,
                    ]);
                    // Success: Record was created
                    return response()->json([
                        'success' => true,
                        'message' => 'Fuel Requested Successfully.',
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
public function update_fuel_request(Request $request) 
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|uuid|exists:fuelings,fueling_id', // Check if UUID exists in the 'users' table
            'fuel_amount' => 'sometimes|required|number',
            'vehicle'=>'sometimes|required|uuid|exists:vehicles,vehicle_id'
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
                $Fuel_Request = FuelsModel::findorFail($id); 
                $user_id = Auth::id();
                     // Check if the record was found
                if($user_id != $Fuel_Request->driver_id)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.'
                            ]);
                        }
                    if($Fuel_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.'
                            ]);
                        } 
                    else
                        {
                                // Update the record with new data
                                $Fuel_Request->update([
                                    'vehicle_id' => $request->vehicle,
                                    'fuel_amount' => $request->fuel_amount,
                                ]);

                                // Return a success response
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Fuel request updated successfully.',
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
            'request_id' => 'required|uuid|exists:fuelings,fueling_id', // Check if UUID exists in the 'users' table
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
                $Fuel_Request = FuelsModel::findOrFail($id);
                if($Fuel_Request->driver_id != $user_id)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service.',
                        ]);
                    }
                if($Fuel_Request->approved_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service.',
                        ]);
                    }
                $Fuel_Request->delete();
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
            $Fuel_Requests = FuelsModel::whereHas('requestedBy', function ($query) use ($dept_id) {
                $query->where('department_id', $dept_id);
            })->get();
            return view("FeulDirectorPage", compact('Fuel_Requests'));
    }
    // DIRECTOR APPROVE THE REQUESTS
public function DirectorApproveRequest(Request $request)
    {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|fuelings,request_id',
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
                $Fuel_Request = FuelsModel::findOrFail($id);
                if($Fuel_Request->approved_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning!, You are denied the service',
                        ]);
                    }
                $Fuel_Request->approved_by = $user_id;
                $Fuel_Request->save();
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
            'request_id'=>'required|fuelings,request_id',
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
                $Fuel_Request = FuelsModel::findOrFail($id);
                if($Fuel_Request->approved_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sorry, Something went wrong',
                        ]);
                    }
                $Fuel_Request->approved_by = $user_id;
                $Fuel_Request->direct_reject_reason = $reason;
                $Fuel_Request->save();
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
            $Fuel_Request = FuelsModel::all();
            return view("Fuel_Requests", compact('Fuel_Requests'));     
    }
    // VEHICLE DIRECTOR APPROVE THE REQUESTS
public function VehicleDirectorApproveRequest(Request $request)
    {
            $validation = Validator::make($request->all(),[
               'request_id' => 'required|uuid|exists:fuelings,fueling_id',
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
            $Fuel_Request = FuelsModel::findOrFail($id);
            if($Fuel_Request->vec_director_id)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sorry, You are denied the service',
                    ]);
                }
            $Fuel_Request->vec_director_id = $user_id;
            $Fuel_Request->save();
            return response()->json([
                'success' => true,
                'message' => 'The Request is successfully Approved',
            ]);
    }
    //vehicle Director Reject the request
public function VehicleDirectorRejectRequest(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'request_id'=>'required|exists:fuelings,fueling_id',
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
        $Fuel_Request = FuelsModel::findOrFail($id);
        if($Fuel_Request->vec_director_id)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Warning! You are denied the service',
                ]);
            }
        $Fuel_Request->vec_director_id = $user_id;
        $Fuel_Request->vec_director_reject_reason = $reason;
        $Fuel_Request->save();
        return response()->json([
            'success' =>true,
            'message' => 'You have successfully Rejected the Request',
        ]);
    }
    // Vehicle Director Page
public function Fuelor_page() 
    {    
            $id = Auth::id();
            $Fuel_Request = FuelsModel::all();
            return view("Fuel_Requests", compact('Fuel_Requests'));     
    }
    // VEHICLE DIRECTOR APPROVE THE REQUESTS
public function FuelorApproveRequest(Request $request)
    {
            $validation = Validator::make($request->all(),[
               'request_id' => 'required|uuid|exists:fuelings,fueling_id',
               'cost'=>'required|number',
               'comment'=>'nullable|string|max:1000',
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
            $cost = $request->input('cost');
            $comment = $request->input('comment');
            $user_id = Auth::id();
            $Fuel_Request = FuelsModel::findOrFail($id);
            if($Fuel_Request->service_given_by)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sorry, You are denied the service',
                    ]);
                }
            $Fuel_Request->service_given_by = $user_id;
            $Fuel_Request->fuel_cost = $cost;
            $Fuel_Request->notes = $comment;
            $Fuel_Request->save();
            return response()->json([
                'success' => true,
                'message' => 'The Request is successfully Approved',
            ]);
    }
    //vehicle Director Reject the request
public function FuelorRejectRequest(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'request_id'=>'required|exists:fuelings,fueling_id',
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
        $Fuel_Request = FuelsModel::findOrFail($id);
        if($Fuel_Request->service_given_by)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Warning! You are denied the service',
                ]);
            }
        $Fuel_Request->service_given_by = $user_id;
        $Fuel_Request->fuelor_reject = $reason;
        $Fuel_Request->save();
        return response()->json([
            'success' =>true,
            'message' => 'You have successfully Rejected the Request',
        ]);
    }
}
