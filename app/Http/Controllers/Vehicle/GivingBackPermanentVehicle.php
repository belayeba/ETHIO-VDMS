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


use App\Http\Controllers\Vehicle\Daily_KM_Calculation;

class GivingBackPermanentVehicle extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    // Display Request Page
public function displayReturnPermRequestPage()
    {
        $id = Auth::id();
        $Requested = VehiclePermanentlyRequestModel::where('requested_by',$id)->where('accepted_by_requestor', $id)->where('status',1)->get();
        $Return = GivingBackVehiclePermanently::where('requested_by', $id)->get();
        // dd($Requested);
        return view("Return.ReturnPermanentVehiclePage",compact('Requested','Return'));
    }
    // Send Vehicle Return Request Parmananently
public function ReturntVehiclePerm(Request $request) 
    {
                   // Validate the request
            $validator = Validator::make($request->all(), [
                'purpose' => 'required|string|max:1000',
                'return_type' => 'required|String|In:Replacement,ForGood',
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id'
            ]);            
                  // If validation fails, return an error response
            if ($validator->fails()) 
                {
                    return redirect()->back()->with('error_message',
                    'All field is required',
                    );
                }
            $logged_user = Auth::id();
            $request_id= $request->input('request_id');
            $get_permanent_request = VehiclePermanentlyRequestModel::find($request_id);
            
            if($get_permanent_request->requested_by != $logged_user || $get_permanent_request->status == false)
              {
                return redirect()->back()->with('error_message',
                    'Warning! You are denied the service',
                    );
              }
            try
                {
                    $today = \Carbon\Carbon::now();
                     $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
                    // Create the user
                    GivingBackVehiclePermanently::create([
                        'vehicle_id'=>$get_permanent_request->vehicle_id,
                        'purpose' =>$request->purpose,
                        'requested_by' => $logged_user,
                        'return_type' => $request->return_type,
                        'permanent_request' =>$get_permanent_request->vehicle_request_permanent_id,
                        'created_at' => $ethiopianDate
                    ]);
                    // Success: Record was created
                    // Redirect page to Permananet
                    return redirect()->back()->with('success_message','Request sent successfully',);
                        
                }
            catch (Exception $e) 
                {
                    // Handle the case when the vehicle request is not found
                    return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.'.$e,
                    );
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
                return redirect()->back()->with('error_message',
                'All field is required.',
                );
            }
        $id = $request->input('request_id');
        try
            {
                $Vehicle_Request = GivingBackVehiclePermanently::find($id); 
                $user_id = Auth::id();
                // Check if the record was found
                if($user_id != $Vehicle_Request->requested_by)
                        {
                            return redirect()->back()->with('error_message',
                            'Warning you are denied the service',
                            );
                        }
                    if($Vehicle_Request->approved_by)
                        {
                            return redirect()->back()->with('error_message',
                            'Warning! You are denied the service',
                            );
                        } 
                    else
                        {
                            $perm_request_id = $Vehicle_Request->permanent_request;
                            $get_permanent_request = VehiclePermanentlyRequestModel::find($perm_request_id);
                            if($get_permanent_request->requested_by != $user_id || $get_permanent_request->status = false)
                              {
                                return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
                              }
                                // Update the record with new data
                                $Vehicle_Request->update([
                                    'purpose' => $request->purpose,
                                ]);
                                // Return a success response
                                return redirect()->back()->with('success_message',
                                'Request updated successfully.',
                                );
                        }
                    }
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                        return redirect()->back()->with('error_message',
                                        'Sorry, Something went wrong.',
                                        );
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
                return redirect()->back()->with('error_message',
                'Warning! You are denied the service.',
                );
            }
        // Check if the request is that of this users
        $id = $request->input('request_id');
        $user_id = Auth::id();
        try 
            {
                $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
                if($Vehicle_Request->requested_by != $user_id || $Vehicle_Request->approved_by)
                    {
                        return redirect()->back()->with('error_message',
                        'Warning! You are denied the service.',
                        );
                    }
                $Vehicle_Request->delete();
                return redirect()->back()->with('success_message',
                        'Deleted successfully',
                    );
            } 
        catch (Exception $e) 
            {
                // Handle the case when the vehicle request is not found

                 return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.',
                    );
            }
    }
// Vehicle Director Page
public function VehicleDirector_page() 
    {   
            $vehicle_requests = GivingBackVehiclePermanently::latest()->get();
           
            return view("Return.vehicle_requests", compact('vehicle_requests'));     
    }

    //this is to fetch for Director
public function FetchReturnDirector( Request $request )
    {
        // dd($request->input('customDataValue'));
        $id = Auth::id();

        $data_drawer_value = $request->input('customDataValue');

        if($data_drawer_value == 1){

            $data = GivingBackVehiclePermanently::latest()->get();
        
            }
        
        elseif($data_drawer_value == 2){
            $data = GivingBackVehiclePermanently::whereNotNull('approved_by')
            ->whereNull('reject_reason_vec_director')
            ->where('return_type', "ForGood")
            ->get();
        }

        elseif($data_drawer_value == 3){
            $data = GivingBackVehiclePermanently::whereNotNull('approved_by')
            ->whereNull('reject_reason_vec_director')
            ->where('return_type', "Replacement")
            ->get();
        }

        else{
            $data = GivingBackVehiclePermanently::whereNotNull('approved_by')
                        ->whereNull('reject_reason_vec_director')
                        ->get();
        }
       
        return datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('counter', function($row) use ($data){
            static $counter = 0;
            $counter++;
            return $counter;
        })

        ->addColumn('requested_by', function ($row) {
            return $row->requestedBy->first_name. ' ' .$row->requestedBy->last_name;
        })

        ->addColumn('vehicle', function ($row) {
            return $row->permanentRequest->vehicle->plate_number;
        })

        ->addColumn('reason', function ($row) {
            return $row->return_type;
        })

        ->addColumn('date', function ($row) {
            return $row->created_at->format('d/m/Y');
        })

        ->addColumn('inspect', function ($row) {
            $button = '<button type="button" class="btn btn-info rounded-pill inspect-btn" 
               data-id="' . $row->permanentRequest->inspection_id . '" title="Show Details">
               Inspect</button>'; 
            return $button;
        })
        

        ->addColumn('status', function ($row) use ($data_drawer_value) {
            if($data_drawer_value == 1){
                if ($row->approved_by !== null && $row->reject_reason_vec_director === null) {
                    return 'ACCEPTED';
                } elseif ($row->approved_by !== null && $row->reject_reason_vec_director !== null) {
                    return 'REJECTED';
                }
                return 'PENDING';
            }
            
            else{
                if ($row->received_by!== null && $row->reject_reason_dispatcher === null && $row->return_type === "ForGood") {
                    return 'ACCEPTED';
                }
                elseif ($row->received_by!== null && $row->reject_reason_dispatcher === null && $row->return_type === "Replacement" && $row->status === 0) { 
                    return 'REPLACEMENT PENDING';
                }
                elseif ($row->received_by!== null && $row->reject_reason_dispatcher === null && $row->return_type === "Replacement" && $row->status === 1) { 
                    return 'REPLACED';
                }
                elseif ($row->received_by !== null && $row->reject_reason_dispatcher !== null) {
                    return 'REJECTED';
                }
                return 'PENDING';
            }
        })
        

        ->addColumn('actions', function ($row) use ($data_drawer_value) {
            $actions='';

            if($data_drawer_value == 1){
                $actions = '<button type="button" class="btn btn-info rounded-pill show-btn" 
                data-id="' . $row->purpose. '" title="Show Details">
                <i class="ri-eye-line"></i></button>'; 
            
                if ($row->approved_by === null) {
                $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->giving_back_vehicle_id. '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->giving_back_vehicle_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                }
            }
            else{
                $actions = '<button type="button" class="btn btn-info rounded-pill show-btn" 
                data-id="' . $row->purpose. '" title="Show Details">
                <i class="ri-eye-line"></i></button>'; 
            
                if ($row->received_by === null)
                 {

                    $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->giving_back_vehicle_id. '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                    $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->giving_back_vehicle_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                
                 }

                 if ($row->received_by !== null && $row->reject_reason_dispatcher === null && $row->return_type === "Replacement" && $row->status === 0)
                 {
                    $actions .= '<button  type="button" class="btn btn-success rounded-pill replace-btn" data-id="' . $row->permanent_request . '" data-givingid="' . $row->giving_back_vehicle_id. '" data-request="' . $row->giving_back_vehicle_id . '" data-vehicle="' . $row->vehicle->plate_number. '" title="Replace"><i class="ri-loop-left-line"></i></button>';                
                 }
            }

            return $actions;
        })

        ->rawColumns(['actions','vehicle','requested_by','counter','Reason','status','date','inspect'])
        ->toJson();
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
                   return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
                }
                // dd($request);
            // Check if it is not approved before
            $id = $request->input('request_id');
            $user_id = Auth::id();
        try
            {
                $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
                if($Vehicle_Request->approved_by)
                    {
                        return redirect()->back()->with('error_message',
                        'Sorry, Something Went Wrong.',
                        );
                    }
                $Vehicle_Request->approved_by = $user_id;
                $Vehicle_Request->save();
                return redirect()->back()->with('success_message',
                                'You approved successfully',
                            );
            }
        catch (Exception $e) 
            {
                // Handle the case when the vehicle request is not found
                return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.',
                    );
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
                return redirect()->back()->with('error_message',
                'Sorry, Something Went Wrong.',
                );
            }
            // }dd($request);
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
                                 "Warning, You are denied the service",
                            );
                    }
                    
                $Vehicle_Request->approved_by = $user_id;
                $Vehicle_Request->reject_reason_vec_director = $reason;
                $user = User::find($Vehicle_Request->requested_by);
                $message = "Your Vehicle Return Request Rejected, click here to see its detail";
                $subject = "Vehicle Returning";
                $url = "/return-permanent-request-page";
                $user->NotifyUser($message,$subject,$url);
                $Vehicle_Request->save();
                return redirect()->back()->with('success_message',
                'You are rejected the request Successfully.',
            );
            }
        catch (Exception $e) 
            {
                // Handle the case when the vehicle request is not found
                return redirect()->back()->with('error_message',
                'Sorry, Something Went Wrong.',
                );
            }
    }
// Dispatcher Page
public function Dispatcher_page() 
    {    
        $vehicles = VehiclesModel::where('rental_type','position')->where('status', 1)->get();
        // $vehicles = VehiclesModel::get();
        return view("Return.DirectorPage", compact('vehicles'));     
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
                    return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.',
                    );
                }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $user_id = Auth::id();
            $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($id);
            $the_vehicle = VehiclesModel::find($Vehicle_Request->permanentRequest->vehicle_id);
            $get_permanent_request = VehiclePermanentlyRequestModel::find($Vehicle_Request->permanent_request );
            if($Vehicle_Request->received_by)
                {
                    return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.',
                    );
                }
            $todayDateTime = Carbon::now();
            $get_permanent_request->status = false;
            $Vehicle_Request->received_by = $user_id;
            $Vehicle_Request->returned_date = $todayDateTime;
            $Vehicle_Request->status = false;
            
            $the_vehicle->status = true;
            $the_vehicle->save();
            $Vehicle_Request->save();
            $get_permanent_request->save();
            $user = User::find($get_permanent_request->requested_by);
            $message = "Your Vehicle Successfully Returned";
            $subject = "Vehicle Returning";
            $url = "/return-permanent-request-page";
            $user->NotifyUser($message,$subject,$url);
            return redirect()->back()->with('success_message',
                                'Vehicle Successfully Returned',
                            );
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
                return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.',
                    );
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
                        return redirect()->back()->with('error_message',
                        'Warning! You are denied the service.',
                        );
                    }
                $Vehicle_Request->received_by = $user_id;
                $Vehicle_Request->reject_reason_dispatcher = $reason;
                $Vehicle_Request->save();
                $user = User::find($Vehicle_Request->requested_by);
                $message = "Your Vehicle Return Request Rejected click here to see its detail";
                $subject = "Vehicle Returning";
                $url = "/return-permanent-request-page";
                $user->NotifyUser($message,$subject,$url);
                return redirect()->back()->with('success_message',
                'You have successfully Rejected the request.',
            );
            }
        catch(Exception $e)
            {
                return redirect()->back()->with('error_message',
                'Sorry, Something Went Wrong.',
                );
            }
    }
}
