<?php

namespace App\Http\Controllers\Mentenance;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\MaintenancesModel;
use App\Models\VehiclesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MentenanceController extends Controller
{
    // Display Request Page for users
    public function displayMaintenanceRequestPage()
        {
            $id = Auth::id();
            $vehicle = VehiclesModel::where('driver_id',$id)->latest()->get();
            $requested = MaintenancesModel::where('requested_by', $id)->latest()->get();
            return view("Maintenance.index",compact('requested','vehicle'));
        }
        // Maintenance Request (Post Data)
    public function RequestMaintenance(Request $request) 
        {
                // Validate the request
                $validator = Validator::make($request->all(), [
                    'maintenance_type' => 'required|string|max:1000',
                    'vehicle'=>'required|uuid|exists:vehicles,vehicle_id'
                ]);            
                // If validation fails, return an error response
                if ($validator->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => "All fields are required",
                        ]);
                    }
                $id = Auth::id();
                try
                    {
                        // Create the user
                        MaintenancesModel::create([
                            'requested_by'=>$id,
                            'vehicle_id' => $request->vehicle,
                            'maintenance_type' => $request->maintenance_type,
                        ]);
                        // Success: Record was created
                        return response()->json([
                            'success' => true,
                            'message' => 'Maintenance Requested Successfully.',
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
    public function update_Maintenance_request(Request $request) 
        {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'request_id' => 'required|uuid|exists:maintenances,maintenance_id', // Check if UUID exists in the 'users' table
                'maintenance_type' => 'sometimes|required|string|max:1000',
                'vehicle'=>'sometimes|required|uuid|exists:vehicles,vehicle_id'
            ]); 
            // Check if validation fails
            if ($validator->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => "All fields are required"
                    ], 422); // 422 Unprocessable Entity
                }
            $id = $request->input('request_id');
            try
                {
                    $Maintenance_Request = MaintenancesModel::findorFail($id); 
                    $user_id = Auth::id();
                        // Check if the record was found
                    if($user_id != $Maintenance_Request->driver_id)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning! You are denied the service.'
                                ]);
                            }
                        if($Maintenance_Request->approved_by)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning! You are denied the service.'
                                ]);
                            } 
                        else
                            {
                                    // Update the record with new data
                                    $Maintenance_Request->update([
                                        'vehicle_id' => $request->vehicle,
                                        'maintenance_type' => $request->maintenance_type,
                                    ]);

                                    // Return a success response
                                    return response()->json([
                                        'success' => true,
                                        'message' => 'Maintenance request updated successfully.',
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
                'request_id' => 'required|uuid|exists:maintenances,maintenance_id', // Check if UUID exists in the 'users' table
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
                    $Maintenance_Request = MaintenancesModel::findOrFail($id);
                    if($Maintenance_Request->driver_id != $user_id)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.',
                            ]);
                        }
                    if($Maintenance_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning! You are denied the service.',
                            ]);
                        }
                    $Maintenance_Request->delete();
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
                // Retrieve the department_id of the current user
                $directors_data = User::where('id', $id)->first(['department_id']);
                $dept_id = $directors_data->department_id;

                // Retrieve Maintenance requests made by other users in the same department, excluding the current user's requests
                $Maintenance_Requests = MaintenancesModel::whereHas('requestedBy', function ($query) use ($dept_id, $id) {
                    $query->where('department_id', $dept_id)
                        ->where('driver_id', '!=', $id);
                })->latest()->get();

                return view("MentenanceDirectorPage", compact('Maintenance_Requests'));
        }
        // DIRECTOR APPROVE THE REQUESTS
    public function DirectorApproveRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|uuid|exists:maintenances,maintenance_id',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => "Warning! You are denied the service",
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $user_id = Auth::id();
            try
                {
                    $Maintenance_Request = MaintenancesModel::findOrFail($id);
                    if($Maintenance_Request->driver_id == $user_id)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning!, You are denied the service',
                            ]);
                        }
                    if($Maintenance_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning!, You are denied the service',
                            ]);
                        }
                    $Maintenance_Request->approved_by = $user_id;
                    $Maintenance_Request->save();
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
                'request_id'=>'required|uud|exists:maintenances,maintenance_id',
                'reason'=>'required|string|max:1000'
            ]);
                // Check validation error
            if ($validation->fails()) 
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'You need to fill all the fields',
                    ]);
                }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            try
                {
                    $Maintenance_Request = MaintenancesModel::findOrFail($id);
                    if($Maintenance_Request->driver_id == $user_id)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Warning!, You are denied the service',
                            ]);
                        }
                    if($Maintenance_Request->approved_by)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'Sorry, Something went wrong',
                            ]);
                        }
                    $Maintenance_Request->approved_by = $user_id;
                    $Maintenance_Request->director_reject_reason = $reason;
                    $Maintenance_Request->save();
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
                $Maintenance_Request = MaintenancesModel::latest()->limit(100)->get();
                return view("Maintenance_Requests", compact('Maintenance_Requests'));     
        }
        // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function VehicleDirectorApproveRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                'request_id' => 'required|uuid|exists:maintenances,maintenance_id',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => "Warning! You are denied the service",
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $user_id = Auth::id();
                $Maintenance_Request = MaintenancesModel::findOrFail($id);
                if($Maintenance_Request->driver_id == $user_id)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sorry, You are denied the service',
                        ]);
                    }
                if($Maintenance_Request->sim_approved_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sorry, You are denied the service',
                        ]);
                    }
                $Maintenance_Request->sim_approved_by = $user_id;
                $Maintenance_Request->save();
                return response()->json([
                    'success' => true,
                    'message' => 'The Request is successfully Approved',
                ]);
        }
        //vehicle Director Reject the request
    public function VehicleDirectorRejectRequest(Request $request)
        {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|exists:maintenances,maintenance_id',
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
            $Maintenance_Request = MaintenancesModel::findOrFail($id);
                 // User cannot reject his/her own request
            if($Maintenance_Request->driver_id == $user_id)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service',
                    ]);
                }
            if($Maintenance_Request->sim_approved_by)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service',
                    ]);
                }
            $Maintenance_Request->sim_approved_by = $user_id;
            $Maintenance_Request->simirit_reject_reason = $reason;
            $Maintenance_Request->save();
            return response()->json([
                'success' =>true,
                'message' => 'You have successfully Rejected the Request',
            ]);
        }
        // Vehicle Director Page
    public function Maintenanceor_page() 
        {    
                $id = Auth::id();
                $Maintenance_Request = MaintenancesModel::latest()->limit(100)->get();
                return view("Maintenance_Requests", compact('Maintenance_Requests'));     
        }
        // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function MaintenanceorApproveRequest(Request $request)
        {
                $validation = Validator::make($request->all(),[
                'request_id' => 'required|uuid|exists:maintenances,maintenance_id',
                'cost'=>'required|number',
                'comment'=>'nullable|string|max:1000',
                ]);
                // Check validation error
                if ($validation->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => "Please fill all the fields",
                        ]);
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $cost = $request->input('cost');
                $comment = $request->input('comment');
                $user_id = Auth::id();
                $Maintenance_Request = MaintenancesModel::findOrFail($id);
                if($Maintenance_Request->maintained_by)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sorry, You are denied the service',
                        ]);
                    }
                $Maintenance_Request->maintained_by = $user_id;
                $Maintenance_Request->cost = $cost;
                $Maintenance_Request->notes = $comment;
                $Maintenance_Request->save();
                return response()->json([
                    'success' => true,
                    'message' => 'The service is successfully delivered',
                ]);
        }
        //vehicle Director Reject the request
    public function MaintenanceorRejectRequest(Request $request)
        {
            $validation = Validator::make($request->all(),[
                'request_id'=>'required|uuid|exists:maintenances,maintenance_id',
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
            $Maintenance_Request = MaintenancesModel::findOrFail($id);
            if($Maintenance_Request->maintained_by)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service',
                    ]);
                }
            $Maintenance_Request->maintained_by = $user_id;
            $Maintenance_Request->Maintenanceor_reject = $reason;
            $Maintenance_Request->save();
            return response()->json([
                'success' =>true,
                'message' => 'You have successfully Rejected the Request',
            ]);
        }
}