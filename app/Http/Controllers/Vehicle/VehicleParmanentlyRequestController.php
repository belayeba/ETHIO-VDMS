<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\InspectionModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use App\Models\Vehicle\GivingBackVehiclePermanently;

class VehicleParmanentlyRequestController extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
        {
            $this->dailyKmCalculation = $dailyKmCalculation;
        }
    // Display Request Page
    public function displayPermRequestPage()
        {
            $id = Auth::id();
            $Requested = VehiclePermanentlyRequestModel::where('requested_by', $id)->latest()->get();
            //$check_permanent = GivingBackVehiclePermanently::where()
            return view("Request.ParmanententRequestPage", compact('Requested'));
        }

        // show list of permanent request
        public function FetchPermanentRequest()
            {
                $id = Auth::id();        
                $data = VehiclePermanentlyRequestModel::where('requested_by', $id)->get();
                
                return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('start_date', function ($row) {
                    return $row->created_at->format('M j, Y,');
                })

                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Approved' : 'Pending';
                })

                ->addColumn('vehicle', function ($row) {
                    return  $row->vehicle_id !== null ? $row->vehicle->plate_number : ' ' ;
                })

                ->addColumn('actions', function ($row){
                    $action = '';

                    if (is_null($row->approved_by) && is_null($row->director_reject_reason)) {
                        $action .= '<button type="button" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal" data-id="' . $row->vehicle_request_permanent_id . '" data-reason="' . $row->purpose. '"  title="edit">
                                    <i class="ri-edit-line"></i>
                                </button>
                               <button type="button" class="btn btn-danger rounded-pill delete-btn" 
                                data-id="' . $row->vehicle_request_permanent_id . '" title="Delete">
                                <i class="ri-close-circle-line"></i></button>';
                    }

                    $action .= '</form>';

                    if (!is_null($row->vehicle_id)) {
                        $action = '<input type="hidden" value="' . $row->vehicle_id . '" id="vehicleselection"> 
                        <a href="#" class="btn btn-info rounded-pill assignBtn" data-id="' . $row->vehicle_id . '" title="Inspect">Inspect</a>';
             
                    }

                    if (!is_null($row->vehicle_id) && !is_null($row->accepted_by_requestor)) {
                        $action .= '<a href="' . route('accept_assigned_vehicle', ['id' => $row->vehicle_request_permanent_id]) . '" class="btn btn-primary rounded-pill" title="Accept">Accept</a>
                                <button type="button" class="btn btn-danger rounded-pill reject-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="' . $row->vehicle_request_permanent_id . '" title="Reject">Reject</button>';
                    }

                    return $action;
                })

                ->rawColumns(['actions','start_date','status','vehicle','counter'])
                ->toJson();
        
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
                return redirect()->back()->with('error_message',
                                    $validator->errors(),
                                );
            }
            $id = Auth::id();
            try 
            {
                $today = \Carbon\Carbon::today();
                $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
                // Create the user
                VehiclePermanentlyRequestModel::create([
                    'requested_by' => $id,
                    'purpose' => $request->purpose,
                    'position_letter' => $request->position_letter,
                    'created_at' => $ethiopianDate
                ]);
                // Success: Record was created
                return redirect()->back()->with('success_message',
                "Request Created Successfully",
                 );
            } 
            catch (Exception $e) 
            {
                // Handle the case when the vehicle request is not found
                return redirect()->back()->with('error_message',
                                "Sorry, Something went wrong",
                                );
            }
        }
    public function update_perm_request(Request $request)
        {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'request_id' => 'required|uuid|exists:vehicle_requests_parmanently,vehicle_request_permanent_id', // Check if UUID exists in the 'vehicle_requests_parmanently' table
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
            try {
                $Vehicle_Request = VehiclePermanentlyRequestModel::find($id);
                $user_id = Auth::id();
                // Check if the record was found
                if ($user_id != $Vehicle_Request->requested_by) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service.'
                    ]);
                }
                if ($Vehicle_Request->approved_by) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service.'
                    ]);
                } else {
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
            } catch (Exception $e) {
                // Handle the case when the vehicle request is not found
            return redirect()->back()->with('error_message',
                                "Sorry, Something went wrong",
                                );
            }
        }
    // User can delete Request
    public function deleteRequest(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
            ]);
            // Check validation error
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors(),
                ]);
            }
            // Check if the request is that of this users
            $id = $request->input('request_id');
            $user_id = Auth::id();
            try {
                $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
                if ($Vehicle_Request->requested_by != $user_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Warning! You are denied the service.',
                    ]);
                }
                if ($Vehicle_Request->approved_by) {
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
            } catch (Exception $e) {
                // Handle the case when the vehicle request is not found
            return redirect()->back()->with('error_message',
                                "Sorry, Something went wrong",
                                );
            }
        }
    // Directors Page
    public function DirectorApprovalPage()
        {
            $id = Auth::id();
           // $directors_data = User::where('id',$id)->get('department_id');
           // $dept_id = $directors_data->department_id;
            $vehicle_requests = VehiclePermanentlyRequestModel::latest()->get();
           // $vehicle_requests = VehiclePermanentlyRequestModel::whereHas('requestedBy', function ($query) use ($dept_id) {
                //$query->where('department_id', $dept_id);
            //})->get();

            return view("Request.PermanentDirectorPage", compact('vehicle_requests'));
        }
    // DIRECTOR APPROVE THE REQUESTS
    public function DirectorApproveRequest(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
            ]);
            // Check validation error
            if ($validation->fails()) {
                return redirect()->back()->with('error_message',
                                    $validation->errors(),
                                );
            }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $user_id = Auth::id();
            try {
                $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
                if ($Vehicle_Request->approved_by) {
                    return redirect()->back()->with('error_message',
                                    "Warning! You are denied the services",
                                );
                }
                $Vehicle_Request->approved_by = $user_id;
                $Vehicle_Request->accepted_by_requestor = Null;
                $Vehicle_Request->save();
                return redirect()->back()->with('success_message',
                    "You are successfully Approved the Request",
                    );
            } 
            catch (Exception $e) {
                // Handle the case when the vehicle request is not found
            return redirect()->back()->with('error_message',
                                "Sorry, Something went wron ".$e,
                                );
            }
        }
    // Director Reject the request
    public function DirectorRejectRequest(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
                'reason' => 'required|string|max:1000'
            ]);
            // Check validation error
            if ($validation->fails()) {
            return redirect()->back()->with('error_message',
                                "Sorry, Something went wrong",
                                );
            }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $reason = $request->input('reason');
            $user_id = Auth::id();
            try {
                $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
                if ($Vehicle_Request->approved_by != null) {
                    return redirect()->back()->with('error_message',
                    "The Request is rejected successfully",
                    );
                }
                $Vehicle_Request->approved_by = $user_id;
                $Vehicle_Request->director_reject_reason = $reason;
                $Vehicle_Request->save();
                $user = User::find($Vehicle_Request->requested_by);
                $message = "Your Vehicle Permanent Request Rejected, click here to see its detail";
                $subject = "Vehicle Permanent";
                $url = "{{ route('vec_perm_request') }}";
                $user->NotifyUser($message,$subject,$url);
                return response()->json([
                    'success' => true,
                    'message' => 'You are successfully Rejected the Request',
                ]);
            } catch (Exception $e) {
                // Handle the case when the vehicle request is not found
            return redirect()->back()->with('error_message',
                                "Sorry, Something went wrong",
                                );
            }
        }
    // Vehicle Director Page
    public function Dispatcher_page()
        {
            $Vehicle_Request = VehiclePermanentlyRequestModel::whereNotNull('approved_by')->get();
            $Vehicle = VehiclesModel::where('status', 1)->get();
            return view("Request.PermanentVehicleDirector", compact('Vehicle_Request', 'Vehicle'));
        }
    // VEHICLE DIRECTOR APPROVE THE REQUESTS
    public function DispatcherApproveRequest(Request $request)
        {
        
            $validation = Validator::make($request->all(), [
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id'
            ]);
            // Check validation error
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors(),
                ]);
            }
            // Check if it is not approved before
            $id = $request->input('request_id');
            $vehicle_id = $request->vehicle_id;
            $the_vehicle = VehiclesModel::findOrFail($vehicle_id);
            if(!$the_vehicle->status)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'This Vehicle is not active',
                ]);
            }
            $latest_inspection = InspectionModel::where('vehicle_id', $vehicle_id)->latest()->first();
            if (!$latest_inspection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fill Inspection First',
                ]);
            }
            $user_id = Auth::id(); 
            $Vehicle_Request = VehiclePermanentlyRequestModel::findOrFail($id);
            if ($Vehicle_Request->given_by) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, You are denied the service',
                ]);
            }
            // dd($Vehicle_Request);
            $today = Carbon::today()->toDateString();
            $Vehicle_Request->given_by = $user_id;
            $Vehicle_Request->vehicle_id = $vehicle_id;
            $Vehicle_Request->inspection_id = $latest_inspection->inspection_id;
            $Vehicle_Request->given_date =  $today;
            $Vehicle_Request->save();
            $user = User::find($Vehicle_Request->requested_by);
            $message = "Your Vehicle Permanent Request Approved, click here to see its detail";
            $subject = "Vehicle Permanent";
            $url = "{{ route('vec_perm_request') }}";
            $user->NotifyUser($message,$subject,$url);
            return response()->json([
                'success' => true,
                'message' => 'The Request is successfully Approved',
            ]);
        }
    //vehicle Director Reject the request
    public function DispatcherRejectRequest(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
                'reason' => 'required|string|max:1000'
            ]);
            // Check validation error
            if ($validation->fails()) {
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
            if ($Vehicle_Request->assigned_by) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warning! You are denied the service',
                ]);
            }
            $Vehicle_Request->given_by = $user_id;
            $Vehicle_Request->vec_director_reject_reason = $reason;
            $Vehicle_Request->save();
            $user = User::find($Vehicle_Request->requested_by);
            $message = "Your Vehicle Permanent Request Rejected, click here to see its detail";
            $subject = "Vehicle Permanent";
            $url = "{{ route('vec_perm_request') }}";
            $user->NotifyUser($message,$subject,$url);
            return response()->json([
                'success' => true,
                'message' => 'You have successfully Rejected the Request',
            ]);
        }
    public function accept_assigned_vehicle($id)
        {

            $logged_user = Auth::id();
            $check_request = VehiclePermanentlyRequestModel::select('vehicle_id','accepted_by_requestor')
                            ->where('vehicle_request_permanent_id',$id)
                            ->where('requested_by',$logged_user)
                            ->whereNotNull('given_by')
                            ->whereNull('vec_director_reject_reason')
                            ->whereNull('accepted_by_requestor')
                            ->latest()
                            ->first();
            if(!$check_request)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Warning! You are denied the service',
                ]);
            }
            $get_the_vehilce = VehiclesModel::find($check_request->vehicle_id);
            if($get_the_vehilce->status = false)
                {
                        return response()->json([
                            'success' => false,
                            'message' => 'Reject Your request because Assigned vehicle is not active',
                        ]);
                }
            $fuel_quata = $get_the_vehilce->fuel_amount;
            $check_request->accepted_by_requestor = $logged_user;
            $get_the_vehilce->status = false;
            $get_the_vehilce->save();
            $check_request->fuel_quata =  $fuel_quata;
            $check_request->save();
            return response()->json([
                'success' => true,
                'message' => 'Vehicle successfully Given to you',
            ]);
        }
    public function reject_assigned_vehicle(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'request_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
                'reason' => 'required|string|max:1000'
            ]);
            // Check validation error
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors(),
                ]);
            }
            $logged_user = Auth::id();
            $check_request = VehiclePermanentlyRequestModel::select('accepted_by_requestor','reject_reason_by_requestor')
                            ->where('vehicle_request_permanent_id',$request->request_id)
                            ->first();
            if($check_request->requested_by != $logged_user || $check_request->given_by == null || $check_request->vec_director_reject_reason != null )
                {
                        return response()->json([
                            'success' => false,
                            'message' => 'Warning! You are denied the service',
                        ]);
                }
            $check_request->given_by = null;
            $check_request->accepted_by_requestor = $logged_user;
            $check_request->reject_reason_by_requestor = $request->reason;
            $check_request->save();
            return response()->json([
                'success' => true,
                'message' => 'Assigned Vehicle Complained successfully',
            ]);
        }
}
