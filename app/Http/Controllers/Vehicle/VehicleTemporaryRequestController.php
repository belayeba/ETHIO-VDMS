<?php

namespace App\Http\Controllers\vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\InspectionModel;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\TaskCompleted;
class VehicleTemporaryRequestController extends Controller
    {
        // Display Request Page
        public function displayRequestPage()
            {
                $id = Auth::id();
                $users = user::all();
                $Requested = VehicleTemporaryRequestModel::with('peoples', 'materials')->where('requested_by_id', $id)->get();
                return view("Request.TemporaryRequestPage",compact('Requested','users'));
            }
            
        public function FetchTemporaryRequest()
            {
                $id = Auth::id();       
                $data = VehicleTemporaryRequestModel::where('requested_by_id', $id)->get();
                
                return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('start_date', function ($row) {
                    return $row->start_date;
                })

                ->addColumn('location', function ($row) {
                    return  '</br> From:'.$row->start_location . ',</br> To: ' . $row->end_locations;
                })

                ->addColumn('actions', function ($row) {
                    $actions = '<button type="button" class="btn btn-info rounded-pill" 
                    data-bs-toggle="modal" 
                    data-bs-target="#standard-modal"
                    data-purpose="' . $row->purpose . '"
                    data-vehicle_type="' . $row->vehicle_type . '"
                    data-start_date="' . $row->start_date . '"
                    data-start_time="' . $row->start_time . '"
                    data-end_date="' . $row->end_date . '"
                    data-end_time="' . $row->end_time . '"
                    data-start_location="' . $row->start_location . '&nbsp;&nbsp;&nbsp;' . $row->end_locations . '"
                    data-passengers=\'' . json_encode($row->peoples) . '\'
                    data-materials=\'' . json_encode($row->materials) . '\'
                    data-dir_approved_by="' . $row->dir_approved_by . '"
                    data-director_reject_reason="' . $row->director_reject_reason . '"
                    data-div_approved_by="' . $row->div_approved_by . '"
                    data-cluster_director_reject_reason="' . $row->cluster_director_reject_reason . '"
                    data-hr_div_approved_by="' . $row->hr_div_approved_by . '"
                    data-hr_director_reject_reason="' . $row->hr_director_reject_reason . '"
                    data-transport_director_id="' . $row->transport_director_id . '"
                    data-vec_director_reject_reason="' . $row->vec_director_reject_reason . '"
                    data-assigned_by="' . $row->assigned_by . '"
                    data-assigned_by_reject_reason="' . $row->assigned_by_reject_reason . '"
                    data-vehicle_id="' . $row->vehicle_id . '"
                    data-vehicle_plate="' . ($row->vehicle ? $row->vehicle->plate_number : '') . '"
                    data-start_km="' . $row->start_km . '"
                    data-end_km="' . $row->end_km . '"
                    title="Show Details">
                    <i class="ri-eye-line"></i></button>';                    
                    if ($row->dir_approved_by == null && $row->director_reject_reason == null) {
                        $actions .= '<a href="'.route('editRequestPage', ['id' => $row->request_id]).'" class="btn btn-secondary rounded-pill" title="edit"><i class="ri-edit-line"></i></a>';
                    }
        
                    return $actions;
                })

                ->rawColumns(['actions','start_date','location','counter'])
                ->toJson();
        
            }
        // Send Vehicle Request Temporary
        public function RequestVehicleTemp(Request $request) 
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
                    'in_out_town'=>'required|boolean',
                    'how_many_days'=>'required|integer',
                    'with_driver'=>'required|integer|in:1,0',
                    'start_date' => 'required|date',
                    'start_time' => 'required|date_format:H:i',
                    'return_date' => 'required|date|after_or_equal:start_date',
                    'return_time' => 'required|date_format:H:i',
                    'start_location' => 'required|string|max:255',
                    'end_location' => 'required|string|max:255',
                    'itemNames.*' => 'nullable|string|max:255',
                    'people_id' => 'nullable|array',
                    'people_id.*' => 'exists:users,id',
                    'itemWeights.*' => 'nullable|numeric|min:0',
                    'itemNames' => 'nullable|equal_count',
                    'itemWeights' => 'nullable|equal_count',
                ]);
                // If validation fails, return an rerror response
                if ($validator->fails()) 
                        {
                            return redirect()->back()->with('error_message',
                                 $validator->errors(),
                            );
                        }
                    try 
                        {
                            DB::beginTransaction();
                            $id = Auth::id();
                            // dd($request->return_time);
                            // Create the vehicle request
                            $Vehicle_Request = VehicleTemporaryRequestModel::create([
                                'purpose' => $request->purpose,
                                'in_out_town' =>$request->in_out_town,
                                'with_driver' =>$request->with_driver,
                                'how_many_days' =>$request->how_many_days,
                                'vehicle_type' => $request->vehicle_type,
                                'requested_by_id'=> $id,
                                'start_location' => $request->start_location,
                                'end_locations' => $request->end_location,
                                'start_date' => $request->start_date,
                                'start_time' => $request->start_time,
                                'end_date' => $request->return_date,
                                'end_time' => $request->return_time,
                            ]);
                            // Handle optional material_name and weight fields
                            $materialNames = $request->input('itemWeights', []);
                            //dd($materialNames);
                            $weights = $request->input('itemWeights', []);
                            foreach ($materialNames as $index => $materialName) 
                                {
                                    $Vehicle_Request->materials()->create([
                                        'material_name' => $materialName,
                                        'weight' => $weights[$index],
                                    ]);
                                }   
                            // Handle optional people IDs
                            $peopleIds = $request->input('people_id', []);
                        
                            foreach ($peopleIds as $personId) {
                                $Vehicle_Request->peoples()->create([
                                    'employee_id' => $personId,
                                ]);
                            }
                        
                            // Commit the transaction
                            DB::commit();
                            $user = User::find($id);  // Find the user to notify
                            $message = "The task has been completed!";
                            $url = url("/tasks/belay");

                            // Send the notification with the dynamic message and URL
                            $user->notifications(new TaskCompleted($message, $url));                            
                            // Return response to user
                            return redirect()->back()->with('success_message',
                                'You successfully requested a vehicle',
                            );
                            // return redirect()->json([
                            //     'success' => true,
                            //     'message' => 'You successfully requested a vehicle',
                            // ]);
                        
                        } 
                    catch (Exception $e) 
                        {
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
        // update request page
        public function editRequestPage($id)
            {   
            
                $users = user::get();
                $Requested = VehicleTemporaryRequestModel::with('peoples', 'materials')
                                ->findOrFail($id);
                return view("Request.EditTemporaryRequestPage",compact('users','Requested'));
            }
        // User can update Request
        public function update(Request $request) 
            {
                // dd($request);
                // Validate the request
                $validator = Validator::make($request->all(), [
                    'request_id' => 'required|uuid|exists:vehicle_requests_temporary,request_id', // Check if UUID exists in the 'users' table
                    'purpose' => 'sometimes|string|max:255',
                    'vehicle_type' => 'sometimes|string',
                    'in_out_town'=>'sometimes|in:1,0',
                    'how_many_days'=>'sometimes|integer',
                    'with_driver'=>'sometimes|in:1,0',
                    'start_date' => 'sometimes|date',
                    'start_time' => 'sometimes|date_format:H:i',
                    'return_date' => 'sometimes|date|after:start_date',
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
                // dd($id);
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
                        if($Vehicle_Request->dir_approved_by)
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
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                      return redirect()->back()->with('error_message',
                                 "Sorry, Something went wrong",
                            );
                    }
            }
        // User can delete Request
        public function deleteRequest(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                        'request_id'=>'required|uuid|vehicle_requests_temporary,request_id',
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
                        if($Vehicle_Request->requested_by_id != $user_id)
                            {
                              return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        if($Vehicle_Request->approved_by)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'You are denied the service.',
                                ]);
                            }
                        $Vehicle_Request->delete();
                       return redirect()->back()->with('success_message',
                                 "Request deleted successfully",
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
        public function DirectorApprovalPage()
            {
                    // $id = Auth::id();
                    // $directors_data = User::select('department_id')->where('id',$id)->first();
                    // $dept_id = $directors_data->department_id;
                    // //dd($dept_id);
                    // $vehicle_requests = VehicleTemporaryRequestModel::whereHas('requestedBy', function ($query) use ($dept_id) {
                    //     $query->where('department_id', $dept_id);
                    // })->latest()->get();
                    //$vehicle_requests=VehicleTemporaryRequestModel::get();
                    return view("Request.DirectorPage");
        }

            // fetching director approval requests
        public function FetchForDirector()
            {
                $id = Auth::id();
                $directors_data = User::select('department_id')->where('id',$id)->first();
                $dept_id = $directors_data->department_id;

                $data = VehicleTemporaryRequestModel::whereHas('requestedBy', function ($query) use ($dept_id) {
                        $query->where('department_id', $dept_id);
                    })->latest()->get();;
                
                return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('requested_by', function ($row) {
                    return $row->requestedBy->first_name;
                })

                ->addColumn('vehicle_type', function ($row) {
                    return $row->vehicle_type;
                })

                ->addColumn('start_location', function ($row) {
                    return $row->start_location;
                })

                ->addColumn('end_location', function ($row) {
                    return $row->end_locations;
                })

                ->addColumn('date', function ($row) {
                    return $row->created_at;
                })

                ->addColumn('status', function ($row) {
                    if ($row->dir_approved_by !== null && $row->director_reject_reason === null) {
                        return 'ACCEPTED';
                    } elseif ($row->dir_approved_by !== null && $row->director_reject_reason !== null) {
                        return 'REJECTED';
                    }
                      return 'PENDING';
                })

                ->addColumn('actions', function ($row) {
                    $actions = '<button type="button" class="btn btn-info rounded-pill" 
                    data-bs-toggle="modal" 
                    data-bs-target="#standard-modal"
                    data-purpose="' . $row->purpose . '"
                    data-vehicle_type="' . $row->vehicle_type . '"
                    data-start_date="' . $row->start_date . '"
                    data-start_time="' . $row->start_time . '"
                    data-end_date="' . $row->end_date . '"
                    data-end_time="' . $row->end_time . '"
                    data-start_location="' . $row->start_location . '&nbsp;&nbsp;&nbsp;' . $row->end_locations . '"
                    data-passengers=\'' . json_encode($row->peoples) . '\'
                    data-materials=\'' . json_encode($row->materials) . '\'
                    data-dir_approved_by="' . $row->dir_approved_by . '"
                    data-director_reject_reason="' . $row->director_reject_reason . '"
                    data-div_approved_by="' . $row->div_approved_by . '"
                    data-cluster_director_reject_reason="' . $row->cluster_director_reject_reason . '"
                    data-hr_div_approved_by="' . $row->hr_div_approved_by . '"
                    data-hr_director_reject_reason="' . $row->hr_director_reject_reason . '"
                    data-transport_director_id="' . $row->transport_director_id . '"
                    data-vec_director_reject_reason="' . $row->vec_director_reject_reason . '"
                    data-assigned_by="' . $row->assigned_by . '"
                    data-assigned_by_reject_reason="' . $row->assigned_by_reject_reason . '"
                    data-vehicle_id="' . $row->vehicle_id . '"
                    data-vehicle_plate="' . ($row->vehicle ? $row->vehicle->plate_number : '') . '"
                    data-start_km="' . $row->start_km . '"
                    data-end_km="' . $row->end_km . '"
                    title="Show Details">
                    <i class="ri-eye-line"></i></button>';                    
                    if ($row->dir_approved_by == null && $row->director_reject_reason == null) {
                        $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                        $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                    }
        
                    return $actions;
                })

                ->rawColumns(['actions','start_date','location','counter'])
                ->toJson();
        
            }

        // Directors Page
        public function DirectorApproveRequest(Request $request)
            { 
                   // $request_id = "request_id".$id;
                    $validation = Validator::make($request->all(),[
                        'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                    ]);
                    // dd($request_id);
                    // Check validation error
                    if ($validation->fails()) 
                        {
                           return redirect()->back()->with('error_message',
                               $validation->errors(),
                            );
                        }
                    // Check if it is not approved before
                    $id = $request->input( 'request_id');
                    $id = $request->input('request_id');
                    
                    $user_id = Auth::id();
                try
                    {
                        // dd("test");
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);

                        if($Vehicle_Request->dir_approved_by)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->dir_approved_by = $user_id;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "The requests approved successfully",
                            );
                    }
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                       return redirect()->back()->with('error_message',
                                 "Something Went Wrong",
                            );
                    }
            }
         // Director Reject the request

        public function DirectorRejectRequest(Request $request)
            {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                    'reason'=>'required|string|max:1000'
                ]);
                    // Check validation error
                if ($validation->fails()) 
                    {
                       return redirect()->back()->with('error_message',
                                 $validation->errors(),
                            );
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $reason = $request->input('reason');
                $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->dir_approved_by)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->dir_approved_by = $user_id;
                        $Vehicle_Request->director_reject_reason = $reason;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "The request rejected successfully",
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
        public function clusterDirectorApprovalPage()
            {
                $userId = Auth::id();

                // Fetch the user with the department and cluster information
                $user = User::with('department')->find($userId);

                // Get the cluster_id from the user's department
                $clusterId = $user->department->cluster_id;
                //dd($clusterId);
                // Query the VehicleTemporaryRequestModel using the cluster_id
                $vehicleRequests = VehicleTemporaryRequestModel::
                with('approvedBy','requestedBy.department')->whereHas('requestedBy.department', function ($query) use ($clusterId) {
                    $query->where('cluster_id', $clusterId);
                })
                    ->where(function($query) {
                        $query->orWhere('how_many_days', '>', 1)
                            ->orWhere('in_out_town', false);
                    })
                    // ->whereNull('div_approved_by')
                    ->whereNotNull('dir_approved_by')
                    ->get();
                    //dd($vehicleRequests);
                // Return the results, for example, passing them to a view
                return view('Request.ClusterDirectorPage', compact('vehicleRequests'));
            }
        // DIRECTOR APPROVE THE REQUESTS
        public function clusterDirectorApproveRequest(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                    'request_id' => 'required|uuid|exists:vehicle_requests_temporary,request_id',
                    ]);
                    // Check validation error
                    if ($validation->fails()) 
                        {
                           return redirect()->back()->with('error_message',
                               $validation->errors(),
                            );
                        }
                    // Check if it is not approved before
                    $id = $request->input('request_id');
                    $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->div_approved_by)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->div_approved_by = $user_id;
                        $Vehicle_Request->save();
                       return redirect()->back()->with('success_message',
                                 "The request approved successfully",
                            );
                    }
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                       return redirect()->back()->with('error_message',
                                 "Something Went Wrong",
                            );
                    }
            }   
        // Director Reject the request
        public function cluster_DirectorRejectRequest(Request $request)
            {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                    'reason'=>'required|string|max:1000'
                ]);
                    // Check validation error
                if ($validation->fails()) 
                    {
                       return redirect()->back()->with('error_message',
                                 $validation->errors(),
                            );
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $reason = $request->input('reason');
                $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->div_approved_by)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->div_approved_by = $user_id;
                        $Vehicle_Request->cluster_director_reject_reason = $reason;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "The request rejected successfully",
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
        // For HR CLUSTER
        public function HRclusterDirectorApprovalPage()
            {
                $userId = Auth::id();

                // Query the VehicleTemporaryRequestModel using the cluster_id
                $vehicleRequests = VehicleTemporaryRequestModel::
                    where(function($query) {
                        $query->orWhere('how_many_days', '>', 0)
                            ->orWhere('in_out_town', true);
                    })
                    // ->whereNull('hr_div_approved_by')
                    ->whereNotNull('div_approved_by')
                    ->
                    get();
                // Return the results, for example, passing them to a view
                return view('Request.HrDirectorPage', compact('vehicleRequests'));
            }
        public function HrclusterDirectorApproveRequest(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                    'request_id' => 'required|uuid|exists:vehicle_requests_temporary,request_id',
                    ]);
                    // Check validation error
                    if ($validation->fails()) 
                        {
                           return redirect()->back()->with('error_message',
                               $validation->errors(),
                            );
                        }
                    // Check if it is not approved before
                    $id = $request->input('request_id');
                    $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->hr_div_approved_by)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->hr_div_approved_by = $user_id;
                        $Vehicle_Request->save();
                       return redirect()->back()->with('success_message',
                                 "The request approved successfully",
                            );
                    }
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                       return redirect()->back()->with('error_message',
                                 "Something Went Wrong",
                            );
                    }
            }   
            // Director Reject the request
        public function Hrcluster_DirectorRejectRequest(Request $request)
            {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                    'reason'=>'required|string|max:1000'
                ]);
                    // Check validation error
                if ($validation->fails()) 
                    {
                       return redirect()->back()->with('error_message',
                                 $validation->errors(),
                            );
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $reason = $request->input('reason');
                $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->hr_div_approved_by)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->hr_div_approved_by = $user_id;
                        $Vehicle_Request->hr_director_reject_reason = $reason;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "The request rejected successfully",
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
        // DIRECTOR APPROVE THE REQUESTS
        public function TransportDirectorApprovalPage()
            {
                $vehicleRequests = VehicleTemporaryRequestModel::with('approvedBy', 'requestedBy')
                ->where(function ($query) {
                    // Check if how_many_days > 1 OR in_out_town is true
                    $query->where(function ($q) {
                        $q->where('how_many_days', '>', 1)
                        ->orWhere('in_out_town', false);
                    })
                    // Apply condition for hr_div_approved_by
                    ->whereNotNull('hr_div_approved_by');
                })
                // Fallback to dir_approved_by if the first condition isn't true
                ->orWhere(function ($query) {
                    $query->where('how_many_days', '<=', 1)
                        ->where('in_out_town', true)
                        ->whereNotNull('dir_approved_by');
                })
                ->get();

            

                   // dd($vehicleRequests);
                // Return the results, for example, passing them to a view
                return view('Request.TransportDirectorPage', compact('vehicleRequests'));
            }

        public function FetchTransportDirector()
            {
                        
                $data = VehicleTemporaryRequestModel::get();
                
                return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('name', function ($row) {
                    return  $row->requestedBy->first_name. ' ' . $row->requestedBy->last_name;
                })

                ->addColumn('type', function ($row) {
                    return  $row->vehicle_type;
                })

                ->addColumn('start_date', function ($row) {
                    return $row->start_date;
                })

                ->addColumn('start_location', function ($row) {
                    return  $row->start_location ;
                })

                ->addColumn('end_location', function ($row) {
                    return  $row->end_locations;
                })

                ->addColumn('actions', function ($row) {
                    $actions = '<button type="button" class="btn btn-info rounded-pill btn-show" data-toggle="modal" data-target="#standard-modal" 
                                data-purpose="' . $row->purpose . '"
                                data-vehicle="' . $row->vehicle_type . '"
                                data-start_date="' . $row->start_date . '"
                                data-start_time="' . $row->start_time . '"
                                data-end_date="' . $row->end_date . '"
                                data-end_time="' . $row->end_time . '"
                                data-start_location="' . $row->start_location . '"
                                data-end_locations="' . $row->end_locations . '"
                                data-passengers="' . $row->peoples->pluck('user.first_name')->implode(', ') . '"
                                data-materials="' . $row->materials->pluck('material_name')->implode(', ') . '"
                                title="Show">
                                <i class="ri-eye-line"></i></button>';
                    
                    if ($row->transport_director_id === null && $row->vec_director_reject_reason === null) {
                        $actions .= '<button id="acceptButton" type="button" class="btn btn-primary rounded-pill" title="Accept" onclick="confirmFormSubmission(\'approvalForm-'.$row->index.'\')"><i class="ri-checkbox-circle-line"></i></button>';
                        $actions .= '<button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-'.$row->index.'" title="Reject"><i class="ri-close-circle-fill"></i></button>';
                    }
                
                    return $actions;
                })

                ->rawColumns(['actions','name','Type','start_date','start_location','end_location','counter'])
                ->toJson();
        
            }
            
        public function TransportDirectorApproveRequest(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                    'request_id' => 'required|uuid|exists:vehicle_requests_temporary,request_id',
                    ]);
                    // Check validation error
                    if ($validation->fails()) 
                        {
                            return redirect()->back()->with('error_message',
                            $validation->errors(),
                            );
                        }
                    // Check if it is not approved before
                    $id = $request->input('request_id');
                    $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->transport_director_id)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->transport_director_id = $user_id;
                        $Vehicle_Request->save();
                       return redirect()->back()->with('success_message',
                                 "The request approved successfully",
                            );
                    }
                catch (Exception $e) 
                    {
                        // Handle the case when the vehicle request is not found
                       return redirect()->back()->with('error_message',
                                 "Something Went Wrong",
                            );
                    }
            }   
            // Director Reject the request
        public function TransportDirectorRejectRequest(Request $request)
            {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                    'reason'=>'required|string|max:1000'
                ]);
                    // Check validation error
                if ($validation->fails()) 
                    {
                       return redirect()->back()->with('error_message',
                                 $validation->errors(),
                            );
                    }
                // Check if it is not approved before
                $id = $request->input('request_id');
                $reason = $request->input('reason');
                $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        if($Vehicle_Request->transport_director_id)
                            {
                               return redirect()->back()->with('error_message',
                                 "Warning, You are denied the service",
                            );
                            }
                        $Vehicle_Request->transport_director_id = $user_id;
                        $Vehicle_Request->vec_director_reject_reason = $reason;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "The request rejected successfully",
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
        // Vehicle Director Page
        public function SimiritPage() 
            {    
                    $vehicles = VehiclesModel::get();
                    $vehicle_requests = VehicleTemporaryRequestModel::
                                    whereNotNull('transport_director_id')
                                    // ->whereNull('vec_director_reject_reason')
                                    // ->whereNull('assigned_by')
                                    ->get();
                    return view("Request.VehicleDirectorPage", compact('vehicle_requests','vehicles'));     
            }
            // VEHICLE DIRECTOR APPROVE THE REQUESTS
        public function simiritApproveRequest(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                        'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                        'assigned_vehicle_id'=>'required|exists:vehicles,vehicle_id',
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
                    $assigned_vehicle = $request->input('assigned_vehicle_id');
                    $user_id = Auth::id();
                // try
                //     {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        $vehicle_info = VehiclesModel::findOrFail($assigned_vehicle);
                              if(!$vehicle_info->driver_id)
                                {
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Assign Driver to this Vehicle first',
                                    ]);
                                }
                           
                        if($Vehicle_Request->assigned_by)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning!, You are denied the service',
                                ]);
                            }
                        $inspection = InspectionModel::select('inspection_id')->where('vehicle_id',$assigned_vehicle)->latest()->first();
                        if(!$inspection)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'This Car has no inspection',
                                ]);
                            }
                          
                        $inspection_id = $inspection->inspection_id;
                        $Vehicle_Request->assigned_by = $user_id;
                        $Vehicle_Request->vehicle_id = $assigned_vehicle;
                        $Vehicle_Request->taking_inspection = $inspection_id;
                        $Vehicle_Request->save();
                       return redirect()->back()->with('success_message',
                                 "ou are successfully Approved the request",
                            );
                //     }   
                // catch (Exception $e) 
                //     {
                //         // Handle the case when the vehicle request is not found
                //       return redirect()->back()->with('error_message',
                //                  "Sorry, Something went wrong",
                //             );
                //     }
            }
            // Vehicle Director Fill start km
        public function simiritFillstartKm(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                        'request_id'=>'required|uuid|exists:vehicle_requests_temporary,request_id',
                        'start_km'=>'required|integer',
                        // 'km_per_litre','required|integer'
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
                        $vehicle = VehiclesModel::findOrFail($Vehicle_Request->vehicle_id);
                        if(!$vehicle->status)
                        {
                            return response()->json([
                                'success' => false,
                                'message' => 'This vehicle is not active',
                            ]);
                        }
                        if($Vehicle_Request->start_km)
                            {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Warning!, You are denied the service',
                                ]);
                            }
                        $Vehicle_Request->start_km = $start_km;
                        // $Vehicle_Request->km_per_litre = $km_per_litre;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                        "You are successfully Approved the request",
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
        //vehicle Director Reject the request
        public function simiritRejectRequest(Request $request)
            {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                    'reason'=>'required|string|max:1000'
                ]);
                    // Check validation error
                if ($validation->fails()) 
                    {
                      return redirect()->back()->with('error_message',
                                 "Sorry, Something went wrong",
                            );
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
                        $Vehicle_Request->assigned_by_reject_reason = $reason;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "The request rejected successfully",
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
        // VEHICLE DIRECTOR APPROVE THE REQUESTS
        public function Returning_temporary_vehicle(Request $request)
            {
                    $validation = Validator::make($request->all(),[
                        'request_id'=>'required|uuid|exists:vehicle_requests_temporary,request_id',
                        'end_km'=>'required|integer'
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
                        if($Vehicle_Request->start_km > $end_km)
                          {
                            return redirect()->back()->with('error_message',
                            "End KM should be greater than Start KM!",); 
                          }
                        $vehicle = VehiclesModel::findOrFail($Vehicle_Request->vehicle_id);
                        $inspection = InspectionModel::where('vehicle_id',$Vehicle_Request->vehicle_id)->latest->first();
                        $latest_inspection = $inspection->vehicle_id;
                        $Vehicle_Request->taken_by = $user_id;
                        $Vehicle_Request->end_km = $end_km;
                        $vehicle->status = true;
                        $Vehicle_Request->status = false;
                        $Vehicle_Request->returning_inspection = $latest_inspection;
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                                 "Return Successfully Done!",
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
        public function driver_accept(Request $request)
            {
                $validation = Validator::make($request->all(),[
                    'request_id'=>'required|exists:vehicle_requests_temporary,request_id',
                ]);
                    // Check validation error
                if ($validation->fails()) 
                    {
                          return redirect()->back()->with('error_message',
                                 "Sorry, Something went wrong",
                            );
                    }
                $logged_user = Auth::id();
                try
                    {
                          $temp_req = VehicleTemporaryRequestModel::findOrFail($request->request_id);
                          $temp_req->returned_by = $logged_user;
                          $vehicle = VehiclesModel::findOrFail($temp_req->vehicle_id);
                          $vehicle->status = true;
                          if(!$temp_req->with_driver)
                            {
                                    if($vehicle->driver_id != $temp_req->logged_user)
                                        {
                                            return response()->json([
                                                'success' => false,
                                                'message' => 'Warning! You are denied the service',
                                            ]);
                                        } 
                                    else 
                                        {
                                            $vehicle->driver_id = null;
                                            $temp_req->save();
                                            $vehicle->save();
                                            return response()->json([
                                                'success' => true,
                                                'message' => 'Vehicle Returned Successfully',
                                            ]);
                                        }
                            }
                         else
                            {
                                if($vehicle->driver_id != $logged_user) 
                                {
                                        return response()->json([
                                            'success' => false,
                                            'message' => 'Warning! You are denied the service',
                                        ]);
                                } 
                                $temp_req->save();
                                $vehicle->save();
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Vehicle Returned Successfully',
                                ]);
                            }
                    }
                catch(Exception $e)
                    {
                      return redirect()->back()->with('error_message',
                                 "Sorry, Something went wrong",
                            );
                    }
            }
    }
