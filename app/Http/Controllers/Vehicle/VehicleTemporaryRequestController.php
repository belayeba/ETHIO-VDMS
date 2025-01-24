<?php

namespace App\Http\Controllers\vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\InspectionModel;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Driver\DriversModel;
use App\Models\Trip\TripPersonsModel;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\TaskCompleted;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use Carbon\Carbon;

class VehicleTemporaryRequestController extends Controller
    {
        protected $dailyKmCalculation;

        public function __construct(Daily_KM_Calculation $dailyKmCalculation)
            {
                $this->dailyKmCalculation = $dailyKmCalculation;
            }
        // Display Request Page
        public function displayRequestPage()
            {
                $id = Auth::id();
                $users = User::get();
                $driver = DriversModel::get();
                $Requested = VehicleTemporaryRequestModel::with('peoples', 'materials')->where('requested_by_id', $id)->get();
                return view("Request.TemporaryRequestPage",compact('Requested','users','driver'));
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
                    return $row->created_at->format('d/m/y');
                })
                ->addColumn('status', function ($row) {
                    if ($row->vehicle_id !== null && $row->start_km == null) {
                        return 'ASSIGNED';
                    } elseif ($row->end_km == null && $row->start_km !== null) {
                        return 'DISPATCHED';
                    } elseif ($row->end_km !== null) {
                        return 'RETURNED';
                    } elseif ($row->assigned_by == null) {
                        return 'PENDING';
                    }elseif ($row->assigned_by_reject_reason != null){
                        return 'REJECTED';
                    }
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
                    data-passengers=\'' . json_encode($row->peoples()->with('user')->get()) . '\'
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
                    data-vehicle_plate="' . ($row->vehicle 
                    ? $row->vehicle->plate_number . '</br>Driver: ' 
                        . ($row->vehicle->driver ? ($row->vehicle->driver->user->first_name ?? 'none') . ' ' . ($row->vehicle->driver->user->last_name ?? 'none') : 'none') 
                        . '</br>Phone: ' 
                        . ($row->vehicle->driver ? ($row->vehicle->driver->user->phone_number ?? 'none') : 'none') 
                    : '') . '"
                    data-start_km="' . $row->start_km . '"
                    data-end_km="' . $row->end_km . '"
                    title="Show Details">
                    <i class="ri-eye-line"></i></button>';                    
                    if ($row->dir_approved_by == null && $row->director_reject_reason == null) {
                        $actions .= '<a href="'.route('editRequestPage', ['id' => $row->request_id]).'" class="btn btn-secondary rounded-pill" title="edit"><i class="ri-edit-line"></i></a>';
                    }

                    if (isset($row->director_reject_reason) || isset($row->cluster_director_reject_reason) || isset($row->hr_director_reject_reason) || 
                        isset($row->vec_director_reject_reason) || isset($row->assigned_by_reject_reason))
                        {
                        $actions .= '<button class="btn btn-danger rounded-pill reject-reason" title="Reject-Reason"
                        data-reason1="' . $row->director_reject_reason . '"
                        data-reason2="' . $row->cluster_director_reject_reason . '"
                        data-reason3="' . $row->hr_director_reject_reason . '"
                        data-reason4="' . $row->vec_director_reject_reason . '"
                        data-reason5="' . $row->assigned_by_reject_reason . '"
                        >reason</button>';
                        }
                    return $actions;
                })

                ->rawColumns(['actions','start_date','location','counter'])
                ->toJson();
        
            }
        public function return_people($id)
           {
              $people = TripPersonsModel::where('request_id',$id)->get();
               if(!$people)
                 {
                    return [];
                 }
           }
        // Send Vehicle Request Temporary
        public function RequestVehicleTemp(Request $request) 
            {
                Validator::extend('equal_count', function ($attribute, $value, $parameters, $validator) use ($request) {
                    $countMaterialName = count($request->input('material_name', []));
                    $countWeight = count($request->input('weight', []));
                    return $countMaterialName === $countWeight;
                }, 'The number of material names and weights must be equal.');
                $today = \Carbon\Carbon::now();
                $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
                // Validate the request
                $validator = Validator::make($request->all(), [
                    'purpose' => 'required|string|max:255',
                    'vehicle_type' => 'required|string',
                    'in_out_town' => 'required|boolean',
                    'with_driver' => 'required|integer|in:1,0',
                    'start_date' => 'required|date',
                    'start_time' => 'required|date_format:H:i|after_or_equal:$today',
                    'return_date' => 'required|date', // Ensure return_date is after or equal to start_date
                    'return_time' => 'required|date_format:H:i',
                    'start_location' => 'required|string|max:255',
                    'end_location' => 'required|string|max:255',
                    'allowed_km' => 'required|numeric',
                    'material_name.*' => 'nullable|string|max:255',
                    'people_id' => 'nullable|array',
                    'people_id.*' => 'exists:users,id',
                    'weight.*' => 'nullable|numeric|min:0',
                    'material_name' => 'nullable|equal_count',
                    'weight' => 'nullable|equal_count',
                ]);
                
                // If validation fails, return an error response
                if ($validator->fails()) {
                    $errorMessages = implode(', ', $validator->errors()->all());
                    return redirect()->back()->with('error_message', $errorMessages);
                }
                
                    try 
                        {
                            DB::beginTransaction();
                            $id = Auth::id();
                            // dd($request->return_time);
                            // Create the vehicle request
                            $today = \Carbon\Carbon::now();
                            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
                            $startDate = Carbon::parse($request->start_date);
                            $returnDate = Carbon::parse($request->return_date);
                            // Calculate the difference in days
                            $how_many_days = $startDate->diffInDays($returnDate);
                            if($request->start_date < $ethiopianDate)
                                {
                                        return redirect()->back()->with('error_message',
                                        'Please! Check Start Date',
                                    );
                                } 
                            if($how_many_days < 0)
                                {
                                        return redirect()->back()->with('error_message',
                                        'Return Date should be greater than Start Date',
                                    );
                                }       
                                // $materialNames = $request->input('material_name', []);
                                // dd($materialNames);              
                            $Vehicle_Request = VehicleTemporaryRequestModel::create([
                                'purpose' => $request->purpose,
                                'in_out_town' =>$request->in_out_town,
                                'with_driver' =>$request->with_driver,
                                'how_many_days' =>$how_many_days,
                                'vehicle_type' => $request->vehicle_type,
                                'requested_by_id'=> $id,
                                'start_location' => $request->start_location,
                                'end_locations' => $request->end_location,
                                'allowed_km' => $request->allowed_km,
                                'start_date' => $request->start_date,
                                'start_time' => $request->start_time,
                                'end_date' => $request->return_date,
                                'end_time' => $request->return_time,
                                'created_at' => $ethiopianDate
                            ]);
                            // Handle optional material_name and weight fields
                            $materialNames = $request->input('material_name', []);
                        //    dd($materialNames);
                            $weights = $request->input('weight', []);
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
                            DB::commit();                         
                            // Return response to user
                            return redirect()->back()->with('success_message',
                                'You successfully requested a vehicle',
                            );
                        
                        } 
                    catch (Exception $e) 
                        {
                            // Rollback the transaction
                            DB::rollBack();
                        
                            // Log the exception
                            Log::error('Error creating vehicle request: ' . $e->getMessage());
                        
                            // Return error response to user
                            return redirect()->back()->with('error_message',
                    'Sorry, Something Went Wrong.',
                    );
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
                        return redirect()->back()->with('error_message',
                                'All field required.',
                                );
                    }
                $id = $request->input('request_id');
                // dd($id);
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id); 
                        $user_id = Auth::id();
                        if($user_id != $Vehicle_Request->requested_by_id)
                            {
                                return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
                            }
                        if($Vehicle_Request->dir_approved_by)
                            {
                                return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
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
                                return redirect()->back()->with('success_message',
                                'Successfully updated.',
                            );
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
                            return redirect()->back()->with('error_message',
                            'All field required',
                            );
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
                                return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
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
                //dd("coming");
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
        public function FetchForDirector(Request $request)
            {
                // dd($request->input('customDataValue'));
                $id = Auth::id();
              
                $data_drawer_value = $request->input('customDataValue');

                $data = $this->fetchDirectorData($id, $data_drawer_value);
               
               
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
                    return $row->created_at->format('d/m/Y');
                })

                ->addColumn('status', function ($row) use ($data_drawer_value) {
                    if ($data_drawer_value == 1) {
                        if ($row->div_approved_by !== null && $row->cluster_director_reject_reason === null) {
                            return 'ACCEPTED';
                        } elseif ($row->div_approved_by !== null && $row->cluster_director_reject_reason !== null) {
                            return 'REJECTED';
                        }
                        return 'PENDING';
                    } elseif ($data_drawer_value == 2) {
                        if ($row->hr_div_approved_by !== null && $row->hr_director_reject_reason === null) {
                            return 'ACCEPTED';
                        } elseif ($row->hr_div_approved_by !== null && $row->hr_director_reject_reason !== null) {
                            return 'REJECTED';
                        }
                        return 'PENDING';
                    } elseif ($data_drawer_value == 3) {
                        if ($row->transport_director_id !== null && $row->vec_director_reject_reason === null) {
                            return 'ACCEPTED';
                        } elseif ($row->transport_director_id !== null && $row->vec_director_reject_reason !== null) {
                            return 'REJECTED';
                        }
                        return 'PENDING';
                    } else {
                        if ($row->dir_approved_by !== null && $row->director_reject_reason === null) {
                            return 'ACCEPTED';
                        } elseif ($row->dir_approved_by !== null && $row->director_reject_reason !== null) {
                            return 'REJECTED';
                        }
                        return 'PENDING';
                    }
                })

                ->addColumn('actions', function ($row)  use ($data_drawer_value) {
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
                    data-passengers=\'' . json_encode($row->peoples()->with('user')->get()) . '\'
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
                    if ($data_drawer_value == 1) {
                        if ($row->div_approved_by == null && $row->cluster_director_reject_reason == null) {
                            $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                            $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                        }
                    } elseif ($data_drawer_value == 2) {
                        if ($row->hr_div_approved_by == null && $row->hr_director_reject_reason == null) {
                            $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                            $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                        }
                    } elseif ($data_drawer_value == 3) {
                        if ($row->transport_director_id == null && $row->vec_director_reject_reason == null) {
                            $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                            $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                        }
                    }
                     else{              
                    if ($row->dir_approved_by == null && $row->director_reject_reason == null) {
                        $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                        $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                    }
                }
                    return $actions;
                })

                ->rawColumns(['actions','start_date','location','counter'])
                ->toJson();
        
            }

        protected function fetchDirectorData($id, $data_drawer_value)
            {

                if($data_drawer_value == 1)
                    {
                        
                        $user = User::with('department')->find($id);

                            if ($user && $user->department) 
                                {
                                    $clusterId = $user->department->cluster_id;

                                    $data = VehicleTemporaryRequestModel::with(['approvedBy', 'requestedBy.department'])
                                        ->whereHas('requestedBy.department', function ($query) use ($clusterId) {
                                            $query->where('cluster_id', $clusterId);
                                        })
                                        ->where(function($query) {
                                            $query->where('how_many_days', '>', 2)
                                                ->orWhere('in_out_town', false);
                                        })
                                        ->whereNull('director_reject_reason') // Fixed trailing space
                                        ->whereNotNull('dir_approved_by')
                                        ->get();
                                } 
                            else 
                                {
                                    // Handle case where the user or department is not found
                                    $data = collect(); // Empty collection
                                }

                    }
                elseif($data_drawer_value == 2)
                    {

                        $data = VehicleTemporaryRequestModel::
                        where(function($query) {
                            $query->where('how_many_days', '>', 2)
                                ->orWhere('in_out_town',false);
                        })
                        ->whereNull('cluster_director_reject_reason')
                        ->whereNotNull('div_approved_by')
                        ->get();
                    }
                elseif($data_drawer_value == 3)
                    {

                        $data = VehicleTemporaryRequestModel::
                                where(function ($query) 
                                    {
                                        // Condition 1: Check in_out_town and hr_div_approved_by
                                        $query->where(function ($q) {
                                                $q->where('in_out_town', false);
                                            })
                                            ->whereNull('hr_director_reject_reason') // Removed the extra space
                                            ->whereNotNull('hr_div_approved_by');
                                    })
                                ->orWhere(function ($query) 
                                    {
                                        // Condition 2: Fallback for how_many_days > 2 and dir_approved_by
                                        $query->where('how_many_days', '>', 2)
                                            ->where('in_out_town', 1)
                                            ->whereNull('hr_director_reject_reason') // Removed the extra space
                                            ->whereNotNull('hr_div_approved_by');
                                    })
                                ->get();

                    }
                else
                    {
                        
                        $directors_data = User::select('department_id')->where('id',$id)->first();
                        $dept_id = $directors_data->department_id;
            
                        $data = VehicleTemporaryRequestModel::whereHas('requestedBy', function ($query) use ($dept_id) {
                                $query->where('department_id', $dept_id);
                            })->latest()->get();;
                    }
                return $data;
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
                        $user = User::find($Vehicle_Request->requested_by_id);
                        $message = "Your Vehicle Temporary Request Rejected, click here to see its detail";
                        $subject = "Vehicle Temporary";
                        $url = "/temp_request_page";
                        $user->NotifyUser($message,$subject,$url);
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
                $user = User::where('id',$userId)->first();

                // Get the cluster_id from the user's department
                $clusterId = $user->department->cluster_id;

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
                        $user = User::find($Vehicle_Request->requested_by_id);
                        $message = "Your Vehicle Temporary Request Rejected, click here to see its detail";
                        $subject = "Vehicle Temporary";
                        $url = "/temp_request_page";
                        $user->NotifyUser($message,$subject,$url);
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
                        $user = User::find($Vehicle_Request->requested_by_id);
                        $message = "Your Vehicle Temporary Request Rejected, click here to see its detail";
                        $subject = "Vehicle Temporary";
                        $url = "/temp_request_page";
                        $user->NotifyUser($message,$subject,$url);
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
                        $q->where('how_many_days', '>', 3)
                        ->orWhere('in_out_town', false);
                    })
                    // Apply condition for hr_div_approved_by
                    ->whereNotNull('hr_div_approved_by');
                })
                // Fallback to dir_approved_by if the first condition isn't true
                ->orWhere(function ($query) {
                    $query->where('how_many_days', '<=', 2)
                        ->where('in_out_town', true)
                        ->whereNotNull('dir_approved_by');
                })
                ->latest()
                ->get();

                // dd($vehicleRequests);
                // Return the results, for example, passing them to a view
                return view('Request.TransportDirectorPage', compact('vehicleRequests'));
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
                        $user = User::find($Vehicle_Request->requested_by_id);
                        $message = "Your Vehicle Temporary Request Rejected, click here to see its detail";
                        $subject = "Vehicle Temporary";
                        $url = "/temp_request_page";
                        $user->NotifyUser($message,$subject,$url);
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
                    $vehicles = VehiclesModel::where('status',1)->get();
                    $vehicle_requests = VehicleTemporaryRequestModel::
                                    whereNotNull('transport_director_id')
                                     ->whereNull('vec_director_reject_reason')
                                     //->whereNull('assigned_by')
                                    ->get();
                    return view("Request.VehicleDirectorPage", compact('vehicle_requests','vehicles'));     
            }
             // fetching director approval requests
        public function FetchForDispatcher(Request $request)
            {
                // dd($request->input('customDataValue'));
            
                $data_drawer_value = $request->input('customDataValue');

                if($data_drawer_value == 1)
                {
                    $data = VehicleTemporaryRequestModel::with('approvedBy', 'requestedBy')
                    ->where(function ($query) {
                        // Check if how_many_days > 1 OR in_out_town is true
                        $query->where(function ($q) {
                            $q->where('how_many_days', '>', 2)
                            ->OrWhere('in_out_town', false);
                        })
                        // Apply condition for hr_div_approved_by
                        ->whereNotNull('transport_director_id')
                        ->whereNull('assigned_by')
                        ->whereNull('start_km')
                        ->whereNull('assigned_by_reject_reason')
                        ->whereNull('vec_director_reject_reason');
                    })
                    // Fallback to dir_approved_by if the first condition isn't true
                    ->orWhere(function ($query) {
                        $query->where('how_many_days', '<=', 2)
                            ->where('in_out_town', true)
                            ->whereNull('director_reject_reason')
                            ->whereNull('assigned_by')
                            ->whereNull('start_km')
                            ->whereNull('assigned_by_reject_reason')
                            ->whereNotNull('dir_approved_by');
                    })
                   
                    
                    ->latest()
                    ->get();
                }
                elseif($data_drawer_value == 2)
                {
                    
                    $data = VehicleTemporaryRequestModel::with('approvedBy', 'requestedBy')
                    ->where(function ($query) {
                        // Check if how_many_days > 1 OR in_out_town is true
                        $query->where(function ($q) {
                            $q->where('how_many_days', '>', 2)
                            ->OrWhere('in_out_town', false);
                        })
                        // Apply condition for hr_div_approved_by
                        ->whereNotNull('transport_director_id')
                        ->whereNotNull('assigned_by')
                        ->whereNull('start_km')
                        ->whereNull('assigned_by_reject_reason')
                        ->whereNull('vec_director_reject_reason');
                    })
                    // Fallback to dir_approved_by if the first condition isn't true
                    ->orWhere(function ($query) {
                        $query->where('how_many_days', '<=', 2)
                            ->where('in_out_town', true)
                            ->whereNull('director_reject_reason')
                            ->whereNotNull('assigned_by')
                            ->whereNull('start_km')
                            ->whereNull('assigned_by_reject_reason')
                            ->whereNotNull('dir_approved_by');
                    })

                    
                    ->latest()
                    ->get();
                }
                elseif($data_drawer_value == 3){
                   
                    $data = VehicleTemporaryRequestModel::with('approvedBy', 'requestedBy')
                    ->where(function ($query) {
                        // Check if how_many_days > 1 OR in_out_town is true
                        $query->where(function ($q) {
                            $q->where('how_many_days', '>', 2)
                            ->OrWhere('in_out_town', false);
                        })
                        // Apply condition for hr_div_approved_by
                        ->whereNotNull('transport_director_id')
                        ->whereNotNull('assigned_by')
                        ->whereNull('end_km')
                        ->whereNull('assigned_by_reject_reason')
                        ->whereNull('vec_director_reject_reason');
                    })
                    // Fallback to dir_approved_by if the first condition isn't true
                    ->orWhere(function ($query) {
                        $query->where('how_many_days', '<=', 2)
                            ->where('in_out_town', true)
                            ->whereNull('director_reject_reason')
                            ->whereNotNull('assigned_by')
                            ->whereNull('end_km')
                            ->whereNull('assigned_by_reject_reason')
                            ->whereNotNull('dir_approved_by');
                    })
                    
                    ->latest()
                    ->get();
                }elseif($data_drawer_value == 4){
                   
                    $data = VehicleTemporaryRequestModel::with('approvedBy', 'requestedBy')
                    ->where(function ($query) {
                        // Check if how_many_days > 1 OR in_out_town is true
                        $query->where(function ($q) {
                            $q->where('how_many_days', '>', 2)
                            ->OrWhere('in_out_town', false);
                        })
                        // Apply condition for hr_div_approved_by
                        ->whereNotNull('transport_director_id')
                        ->whereNotNull('assigned_by')
                        ->whereNotNull('end_km')
                        ->whereNull('assigned_by_reject_reason')
                        ->whereNull('vec_director_reject_reason');
                    })
                    // Fallback to dir_approved_by if the first condition isn't true
                    ->orWhere(function ($query) {
                        $query->where('how_many_days', '<=', 2)
                            ->where('in_out_town', true)
                            ->whereNull('director_reject_reason')
                            ->whereNotNull('assigned_by')
                            ->whereNotNull('end_km')
                            ->whereNull('assigned_by_reject_reason')
                            ->whereNotNull('dir_approved_by');
                    })
                    
                    ->latest()
                    ->get();
                }
                else{
                    $data = VehicleTemporaryRequestModel::with('approvedBy', 'requestedBy')
                    ->where(function ($query) {
                        // Check if how_many_days > 1 OR in_out_town is true
                        $query->where(function ($q) {
                            $q->where('how_many_days', '>', 2)
                            ->OrWhere('in_out_town', false);
                        })
                        // Apply condition for hr_div_approved_by
                        ->whereNotNull('transport_director_id')
                        ->whereNull('vec_director_reject_reason');
                    })
                    // Fallback to dir_approved_by if the first condition isn't true
                    ->orWhere(function ($query) 
                        {
                            $query->where('how_many_days', '<=', 2)
                                ->where('in_out_town', true)
                                ->whereNull('director_reject_reason')
                                ->whereNotNull('dir_approved_by');
                        })
                    ->latest()
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
                    return $row->created_at->format('d/m/Y');
                })

                ->addColumn('status', function ($row) {
                    if ($row->vehicle_id !== null && $row->start_km == null) {
                        return 'ASSIGNED';
                    } elseif ($row->end_km == null && $row->start_km !== null) {
                        return 'DISPATCHED';
                    } elseif ($row->end_km !== null) {
                        return 'RETURNED';
                    } elseif ($row->assigned_by == null) {
                        return 'PENDING';
                    }elseif ($row->assigned_by_reject_reason != null){
                        return 'REJECTED';
                    }
                })

                ->addColumn('actions', function ($row)  use ($data_drawer_value) {
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
                    data-passengers=\'' . json_encode($row->peoples()->with('user')->get()) . '\'
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
                    data-vehicle_plate="' . ($row->vehicle 
                    ? $row->vehicle->plate_number . '</br>Driver: ' 
                        . ($row->vehicle->driver ? ($row->vehicle->driver->user->first_name ?? 'none') . ' ' . ($row->vehicle->driver->user->last_name ?? 'none') : 'none') 
                        . '</br>Phone: ' 
                        . ($row->vehicle->driver ? ($row->vehicle->driver->user->phone_number ?? 'none') : 'none') 
                    : '') . '"
                    data-start_km="' . $row->start_km . '"
                    data-end_km="' . $row->end_km . '"
                    title="Show Details">
                    <i class="ri-eye-line"></i></button>'; 
                    // if ($data_drawer_value == 1 || $data_drawer_value == 0) {
                        if ($row->assigned_by == null) {
                            $actions .= '<button type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '"  title="accept"><i class=" ri-checkbox-circle-line"></i></button>';
                            $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '"  title="reject"><i class=" ri-close-circle-fill"></i></button>';
                        }
                    // }
                    //  elseif ($data_drawer_value == 2 || $data_drawer_value == 0) {
                        elseif ($row->start_km == null && $row->assigned_by != null && $row->assigned_by_reject_reason  == null ) {
                            $actions .= '<button type="button" class="btn btn-warning rounded-pill dispatch-btn" data-id="' . $row->request_id . '" data-plate="' . $row->vehicle->plate_number . '" title="Dispatch"><i class="  ri-contract-right-fill"></i></button>';
                        }
                    // } 
                    // elseif ($data_drawer_value == 3 || $data_drawer_value == 0) {
                        elseif ($row->start_km != null && $row->end_km == null  ) {
                            $actions .= '<button type="button" class="btn btn-secondary rounded-pill return-btn" data-id="' . $row->request_id . '" data-plate="' . $row->vehicle->plate_number . '"  title="Return"><i class="  ri-contract-left-fill"></i></button>';
                        }
                    // }
                    //  else{              
                    // if ($row->dir_approved_by == null && $row->director_reject_reason == null) {
                        // $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->request_id . '" title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                        // $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->request_id . '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                    // }
                // }
                    return $actions;
                })

                ->rawColumns(['actions','start_date','location','counter'])
                ->toJson();
        
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
                            return redirect()->back()->with('error_message',
                            'All field required',
                            );
                        }
                    // Check if it is not approved before
                    $id = $request->input('request_id');
                    $assigned_vehicle = $request->input('assigned_vehicle_id');
                    $user_id = Auth::id();
                try
                    {
                        $Vehicle_Request = VehicleTemporaryRequestModel::findOrFail($id);
                        $vehicle_info = VehiclesModel::findOrFail($assigned_vehicle);
                              if(!$vehicle_info->driver_id)
                                {
                                    return redirect()->back()->with('error_message',
                                    'Assign Driver to this Vehicle First',
                                    );
                                }
                           
                        if($Vehicle_Request->assigned_by)
                            {
                                return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
                            }
                        $inspection = InspectionModel::select('inspection_id')->where('vehicle_id',$assigned_vehicle)->latest()->first();
                        $inspection_id = null;
                        if(!$inspection)
                            {
                                $inspection_id = $inspection->inspection_id;
                            }
                        $inspection_id = $inspection_id;
                        $Vehicle_Request->assigned_by = $user_id;
                        $Vehicle_Request->vehicle_id = $assigned_vehicle;
                        $Vehicle_Request->taking_inspection = $inspection_id;
                        $Vehicle_Request->save();
                        $user = User::find($Vehicle_Request->requested_by_id);
                        $message = "The Vehcicle is temporarily assigned to you, click here to see its detail";
                        $subject = "Vehicle Temporary";
                        $url = "/temp_request_page";
                        $user->NotifyUser($message,$subject,$url);
                       return redirect()->back()->with('success_message',
                                 "You are successfully Assigned Vehicle for this request",
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
                            return redirect()->back()->with('error_message','Fill start km',);
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
                            return redirect()->back()->with('error_message',
                                'The vehicle is not active',
                                );
                        }
                        if($Vehicle_Request->start_km)
                            {
                                return redirect()->back()->with('error_message',
                                'Warning! You are denied the service.',
                                );
                            }

                        $Vehicle_Request->start_km = $start_km;
                        // $Vehicle_Request->km_per_litre = $km_per_litre;
                        $vehicle->status = false;
                        $vehicle->save();
                        $Vehicle_Request->save();
                        return redirect()->back()->with('success_message',
                        "You are successfully Dispatched the Vehicle",
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
                                return redirect()->back()->with('error_message',
                                'Sorry, Something Went Wrong.',
                                );
                            }     
                        $Vehicle_Request->assigned_by = $user_id;
                        $Vehicle_Request->assigned_by_reject_reason = $reason;
                        $Vehicle_Request->save();
                        $user = User::find($Vehicle_Request->requested_by_id);
                        $message = "Your Vehicle Temporary Request Rejected, click here to see its detail";
                        $subject = "Vehicle Temporary";
                        $url = "/temp_request_page";
                        $user->NotifyUser($message,$subject,$url);
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
                            return redirect()->back()->with('error_message',
                            'All fields are required',
                            );
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
                        $inspection = InspectionModel::where('vehicle_id', $Vehicle_Request->vehicle_id)->latest()->first();
                        $latest_inspection = $inspection->inspection_id;
                        $Vehicle_Request->taken_by = $user_id;
                        $Vehicle_Request->end_km = $end_km;
                        $vehicle->status = true;
                        $Vehicle_Request->status = false;
                        $Vehicle_Request->returning_inspection = $latest_inspection;
                        $Vehicle_Request->save();
                        $vehicle->save();
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
                          $vehicle->status = false;
                          if(!$temp_req->with_driver)
                            {
                                    if($vehicle->driver_id != $temp_req->logged_user)
                                        {
                                            return redirect()->back()->with('error_message',
                                        'Warning! You are denied the service.',
                                        );
                                        } 
                                    else 
                                        {
                                            $vehicle->driver_id = null;
                                            $temp_req->save();
                                            $vehicle->save();
                                            return redirect()->back()->with('success_message',
                                            'Vehicle Successfully Returned back.',
                                        );
                                        }
                            }
                         else
                            {
                                if($vehicle->driver_id != $logged_user) 
                                {
                                    return redirect()->back()->with('error_message',
                                    'Warning! You are denied the service.',
                                    );
                                } 
                                $temp_req->save();
                                $vehicle->save();
                                return redirect()->back()->with('success_message',
                                'Vehicle Returned Successfully.',
                            );
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
