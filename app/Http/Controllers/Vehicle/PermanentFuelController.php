<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use App\Models\ParmanentFueling;
use App\Models\Vehicle\PermanentFuelModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use App\Models\Vehicle\FeulCosts;
use App\Models\Vehicle\VehiclesModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PermanentFuelController extends Controller {
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
        {
            $this->dailyKmCalculation = $dailyKmCalculation;
        }
    public function index() 
        {

            $logged_user = Auth::id();
            $vehicles = VehiclePermanentlyRequestModel::select('vehicle_id')->where('requested_by',$logged_user)
                                                            ->where('status' , 1)
                                                            ->whereNotNull('accepted_by_requestor')
                                                            ->get();                                  
            if($vehicles->isEmpty())
                {
                    return redirect()->back()->with('error_message',
                    "You have not taken vehicle",
                    );
                }
            return view( 'Fuelling.ParmanententRequestPage',compact('vehicles'));
        }
    public function getPreviousCost(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                'month' => 'required|In:1,2,3,4,5,6,7,8,9,10,11,12,13',
                'year' => 'required|integer',
            ] );
            if ($validator->fails()) 
                {
                    return redirect()->back()->with('error_message',
                        $validator->errors(),
                    );
                }
            $logged_user = Auth::id();
            $get_driver = DriversModel::where('user_id',$logged_user)->first();
            $year = $request->input('year');
            $month = $request->input('month');
            $vehicle_id = $request->input('vehicle_id');
            if ($month == 1) {
                $year = $year - 1;
                $month = 12;
            } else {
                $month = $month - 1;
            }
            // Fetch the current month's fuel record for the given driver
            $fueling_of_one = PermanentFuelModel::where('driver_id', $get_driver->driver_id)
                ->where('year', $year)
                ->where('month', $month)
                ->where('vehicle_id', $vehicle_id)
                ->first();
            
            if (!$fueling_of_one) {
                // Return an error response if no record is found
                return response()->json([
                    'status' => 'success',
                    'message' => 'Previous cost calculated successfully.',
                    'data' => [
                        'expected_total' => null,
                        'previous_fuel' => null
                    ]
                ], 200);
            }    
            // Fetch the previous month's fuel record
            $get_previous_feul = PermanentFuelModel::where('year', $year)
                ->where('month', $month)
                ->where('vehicle_id', $fueling_of_one->vehicle_id)
                ->latest()
                ->first();
                $expected_total = 0;
            if ($get_previous_feul) {
                // Calculate the expected total if the previous record exists
                $expected_total = $get_previous_feul->one_litre_price * $get_previous_feul->quata;
        
                return response()->json([
                    'status' => 'success',
                    'message' => 'Previous cost calculated successfully.',
                    'data' => [
                        'expected_total' => $expected_total,
                        'previous_fuel' => $get_previous_feul
                    ]
                ], 200);
            } else {
                // Return a response indicating no previous cost is available
                return response()->json([
                    'status' => 'success',
                    'message' => 'No previous cost available.',
                    'data' => [
                        'expected_total' => $expected_total,
                        'previous_fuel' => $get_previous_feul
                    ]
                ], 200);
            }
        }
        
    public function fuel_request_fetch() 
        {
            $logged_user = Auth::id();
            $get_driver = DriversModel::where('user_id',$logged_user)->first();
            $fueling = PermanentFuelModel::where('driver_id',$get_driver->driver_id)->get();
            $data = PermanentFuelModel::select('fueling_id','vehicle_id','driver_id','month','year','finance_approved_by')
                                            ->where('driver_id', $get_driver->driver_id)
                                            ->distinct()
                                            ->latest()
                                            ->get();
                    // if ($fueling->isEmpty()) {
                    //     return redirect()->back()->with('error_message','Request Not found',);
                    // } 
                    return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('counter', function($row) use ($data){
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                   
                    ->addColumn('vehicle', function ($row) {
                        return $row->vehicle->plate_number;
                    })

                    ->addColumn('status', function ($row)  {
                        return $row->status_check($row->fueling_id) ;
                    })

                    ->addColumn('month', function ($row) {
                        return $row->month . '/' . $row->year;
                    })
                    ->addColumn('action', function ($row) {
                        $actions = '<button type="button" class="btn btn-info rounded-pill view-btn" data-id="' . $row->fueling_id . '"><i class="ri-eye-line"></i></button>
                                    ';
                        
                        return $actions;
                    })

                    ->rawColumns(['counter','vehicle','status','month','action'])
                    ->toJson();
        }
    public function my_request()
        {
            $logged_user = Auth::id();
            $get_driver = DriversModel::where('user_id',$logged_user)->first();
            $get_my_request = PermanentFuelModel::where('driver_id',$get_driver->driver_id)->latest()->get();
            return response()->json(['my_requests' => $get_my_request]);
        }
    public function store( Request $request ) 
        {
            // dd($request->input('fuel_amount')); 
            // Validate input
            $validator = Validator::make($request->all(), [
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                'fuiling_date.*' => 'required|date',
                'month' => 'required|In:1,2,3,4,5,6,7,8,9,10,11,12,13',
                'year' => 'required|integer',
                'fuel_cost.*' => 'required|numeric',
                'reciet_attachment.*' => 'required|file|mimes:jpeg,png,pdf|max:2048'
            ] );
            if ($validator->fails()) 
                {
                    return redirect()->back()->with('error_message',
                        $validator->errors(),
                    );
                }
            try
            {
                $check_request = PermanentFuelModel::where('vehicle_id',$request->input('vehicle_id'))
                                                      ->where('year',$request->input('year'))
                                                      ->where('month',$request->input('month'))
                                                      ->first();
                if($check_request)
                  {
                        return redirect()->back()->with('error_message',
                            "Already Requested for this month",
                        );
                  }
            // Get logged-in user ID
            $logged_user = Auth::id();

            //Get driver based on the logged-in user
            $get_driver = DriversModel::select( 'driver_id' )->where( 'user_id', $logged_user )->first();
            // Ensure that the driver exists
            if ( !$get_driver ) 
                {
                    return redirect()->back()->with('error_message',
                    "You should be registered as driver.",
                    );
                }
            $the_driver_id = $get_driver->driver_id;
            // Get permanent vehicle request associated with driver and vehicle
            $permanent = VehiclePermanentlyRequestModel::select( 'vehicle_request_permanent_id','fuel_quata','feul_left_from_prev' )
                    ->where( 'requested_by', $logged_user )
                    ->where( 'vehicle_id',$request->vehicle_id)// $request->vehicle_id )
                    ->where( 'status', true )
                    ->first();
            // Ensure that the permanent vehicle request exists
            if ( !$permanent ) {
                return redirect()->back()->with('error_message','No active permanent vehicle request found for this driver and vehicle.');
            }

            $get_permanent_id = $permanent->vehicle_request_permanent_id;
            // Loop through each set of fueling data
            $fuel=Str::uuid();
            $today = \Carbon\Carbon::today();
            $files = $request->file( "reciet_attachment_" );
            $fueling_date = $request->input('fuiling_date');
            // $fuel_amount = $request->input('fuel_amount');
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            DB::beginTransaction(); // Begin a transaction
            foreach ( $request->fuel_cost as $index => $fuel_amount ) 
            {
                // dd($fuel_amount);
                $fueling = new PermanentFuelModel();
                $fueling->fueling_id = $fuel;
                $fueling->vehicle_id = $request->input('vehicle_id');
                $fueling->driver_id = $the_driver_id;
                $fueling->permanent_id = $get_permanent_id;
                $date = Carbon::parse($fueling_date[$index])->toDateTime(); 
                // Call your ConvertToEthiopianDate function
                $fueling->fuiling_date = $this->dailyKmCalculation->ConvertToEthiopianDate($date);
                $fueling->month = $request->month;
                $fueling->year = $request->year;
                //$fueling->fuel_amount = $fuel_amount;
                $fueling->fuel_cost = $request->fuel_cost[ $index ];
                
                if ($files[$index] )  
                    {
                        $file = $files[$index];
                        $fileName = time() . '_' . $file->getClientOriginalName(); // Generate unique filename
                        $storagePath = storage_path( 'app/public/vehicles/reciept' ); // Define storage path
                        // Check if directory exists, if not create it
                        if ( !file_exists( $storagePath ) ) {
                            mkdir( $storagePath, 0755, true );
                        }
                        // Move file to the storage path
                        $file->move( $storagePath, $fileName );
                        // Assign file name to the model
                        $fueling->reciet_attachment = $fileName; 
                        
                    }
                $fueling->created_at = $ethiopianDate;
                $fueling->save();
            }
            DB::commit();
            return redirect()->route( 'permanenet_fuel_request' )->with( 'success', 'Fueling records created successfully.' );
            }
            catch(Exception $e)
                {
                    DB::rollBack();
                    return redirect()->back()->with('error_message','Sorry, Something Went Wrong'.$e);
                }
        }
        
    public function show( $id ) 
        {
            
            // dd($id);
            $fueling = PermanentFuelModel::where('fueling_id',$id )->get();
            $fueling_of_one = PermanentFuelModel::where('fueling_id',$id )->first();
            // dd($fueling);

            if ($fueling->isEmpty()) {
                return redirect()->back()->with('error_message','Request Not found',);
            } 
            //dd($fueling_of_one->month);
            if($fueling_of_one->month == 1)
                {
                    $year = $fueling_of_one->year-1;
                    $get_previous_feul = PermanentFuelModel::where('year',$year )->where('month',12)->where('vehicle_id',$fueling_of_one->vehicle_id)->latest()->first();
                }
            else
                {
                    $month = $fueling_of_one->month - 1;
                    $get_previous_feul = PermanentFuelModel::where('year',$fueling_of_one->year)->where('month',$month)->where('vehicle_id',$fueling_of_one->vehicle_id)->latest()->first();
                    //dd( $get_previous_feul->one_litre_price * $get_previous_feul->quata);

                }
            if($get_previous_feul)
                {
                    $expected_total = $get_previous_feul->one_litre_price * $get_previous_feul->quata;
                }
            else
               {
                $expected_total = "None";
               }
            $total_feul =  $fueling->sum('fuel_cost');
            $fueling_data= PermanentFuelModel::with('vehicle:vehicle_id,plate_number','financeApprover:id,first_name')
            ->select('driver_id','fueling_id','finance_approved_by','fuel_cost','fuiling_date','reciet_attachment','year','month','make_primary','accepted','final_approved_by')
            ->where('fueling_id', $id)
            ->get()                
            ->map(function ($fueling) {
                return [
                    'primary'            => $fueling->make_primary,
                    'accepted'            => $fueling->accepted, 
                    'fueling_id'         => $fueling->fueling_id,
                    'year'               => $fueling->year,
                    'month'              => $fueling->month,
                    'final_approved'     => $fueling->finalApprover ? $fueling->finalApprover->first_name : null,
                    'fuel_cost'          => $fueling->fuel_cost,
                    'fuiling_date'       => $fueling->fuiling_date,
                    'reciet_attachment'  => $fueling->reciet_attachment,
                    'finance_approved_by'=> $fueling->finance_approved_by? $fueling->financeApprover->first_name : 'not approved',
                ];
            });
            return response()->json(['status' => 'success', 'data' => $fueling_data,'total_fuel'=>$total_feul,'expected_fuel' =>$expected_total]);
    
        }
    public function update(Request $request)
        {
           
            // Validate input
            $validator = Validator::make($request->all(), [
                'make_primary' => 'required|uuid|exists:permanent_fuelings,make_primary',
                'fuiling_date' => 'required|date',        // Fueling date is an array
                'fuel_cost' => 'required|numeric',        // Fuel cost is an array
                'reciet_attachment' => 'sometimes|file|mimes:pdf,jpg,jpeg,png' // Receipt attachment is an array, optional
            ]);
            if ($validator->fails()) 
            {
                return redirect()->back()->with('error_message',
                     $validator->errors(),
                );
            }
            // Get logged-in user ID
            $logged_user = Auth::id();
        
            // Get driver based on the logged-in user
            $get_driver = DriversModel::select('driver_id')->where('user_id', $logged_user)->first();
        
            // Ensure that the driver exists
            if (!$get_driver) {
                return redirect()->back()->with('error_message',
                "You are not Registered as Driver",
           );
            }
        
            $get_driver_id = $get_driver->driver_id;
            // Get permanent vehicle request associated with driver and vehicle
            $permanent = VehiclePermanentlyRequestModel::select('vehicle_request_permanent_id')
                ->where('driver_id', $get_driver_id)
                ->where('vehicle_id', $request->vehicle_id)
                ->where('status', true)
                ->first();
                
            // Ensure that the permanent vehicle request exists
            if (!$permanent) {
                return  response()->json(['error' => 'No active permanent vehicle request found for this driver and vehicle.']);
            }
        
        
            // Fetch the existing fueling record by ID (could be the main record, e.g., $id)
            $fueling = PermanentFuelModel::findOrFail($request->input('make_primary'));
            if($fueling->driver_id != $get_driver_id || $fueling->finance_approved_by)
            {
                    return redirect()->back()->with('error_message',
                    "Warning! You are denied the service",
                    );
            } 
                
                $fueling->fuiling_date = $request->fuiling_date;  // Array for fueling date
                $fueling->month = $request->month;  // Month is the same for all records
                $fueling->fuel_cost = $request->fuel_cost;  // Fuel cost at this index
        
                if ($request->hasFile("reciet_attachment")) {
                    $file = $request->file( "reciet_attachment" );
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $storagePath = storage_path( 'app/public/vehicles/reciept' );
                    if (!file_exists( $storagePath ) ) {
                        mkdir( $storagePath, 0755, true );
                    }
                    $file->move( $storagePath, $fileName );
                    $fueling->reciet_attachment = $fileName;
                }
                $fueling->update();
                return redirect()->back()->with('success_message',
                "Successfully Updated",
                );
        }
    public function attach_new_reciet(Request $request)
        {
            // Validate input
            $validator = Validator::make($request->all(), [
                'id' => 'required|string',
                'fuiling_date' => 'required|date',        // Fueling date is an array
                'fuel_cost' => 'required|numeric',        // Fuel cost is an array
                'reciet_attachment' => 'required|file|mimes:pdf,jpg,jpeg,png' // Receipt attachment is an array, optional
            ]);
            if ($validator->fails()) 
                {
                    return response()->json(['error_message' =>  $validator->errors(),], 500);
                  
                }
            // Get logged-in user ID
            $logged_user = Auth::id();
        
            // Get driver based on the logged-in user
            $get_driver = DriversModel::select('driver_id')->where('user_id', $logged_user)->first();
        
            // Ensure that the driver exists
            if (!$get_driver) {
                return  response()->json(['error_message',
                "You are not Registered as Driver"],400
           );
            }
        
            $get_driver_id = $get_driver->driver_id;
        
            // Fetch the existing fueling record by ID (could be the main record, e.g., $id)
            $former_fueling = PermanentFuelModel::select('final_approved_by','vehicle_id','driver_id','month','year','permanent_id')->where('fueling_id',$request->id)->first();
            if(!$former_fueling)
              {
                return  response()->json(['error_message',
                    "Warning! You are denied the service",]);
              }
            if($former_fueling->driver_id != $get_driver_id || $former_fueling->final_approved_by)
                {
                        return  response()->json(['error_message',
                        "Warning! You are denied the service",],400);
                } 
                
            $today = \Carbon\Carbon::today();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            $fueling = new PermanentFuelModel();
            $fueling->fueling_id = $request->id;
            $fueling->vehicle_id = $former_fueling->vehicle_id;
            $fueling->driver_id = $former_fueling->driver_id;
            $fueling->permanent_id = $former_fueling->permanent_id;
            // dd($request->fuiling_date[ $index ]);
            $fueling->fuiling_date = $request->input('fuiling_date');
            $fueling->month = $former_fueling->month;
            $fueling->year = $former_fueling->year;
            //$fueling->fuel_amount = $fuel_amount;
            $fueling->fuel_cost = $request->input('fuel_cost');
            
            if ($request->hasFile("reciet_attachment")) {
                $file = $request->file( "reciet_attachment" );
                $fileName = time() . '_' . $file->getClientOriginalName();
                $storagePath = storage_path( 'app/public/vehicles/reciept' );
                if (!file_exists( $storagePath ) ) {
                    mkdir( $storagePath, 0755, true );
                }
                $file->move( $storagePath, $fileName );
                $fueling->reciet_attachment = $fileName;
            }
            $fueling->created_at = $ethiopianDate;
            $fueling->save();
                return  response()->json(['success'=>true,
                "message"=>"Successfully attached"], 200);
        }
    public function destroy( $id ) 
        {
            $logged_user = Auth::id();

            // Get driver based on the logged-in user
            $get_driver = DriversModel::select( 'driver_id' )->where( 'user_id', $logged_user )->first();

            // Ensure that the driver exists
            if ( !$get_driver ) {
                return redirect()->back()->with('error_message',
                "Warning! You are denied the service",
                );
            }        
            $fueling = PermanentFuelModel::findOrFail( $id );
            if($fueling->driver_id != $get_driver->driver_id || $fueling->final_approved_by)
                {
                    return redirect()->back()->with('error_message',
                       "Warning! You are denied the service",
                    );
                } 
            $fueling->delete();

            return redirect()->route( 'fuelings.index' )->with( 'success', 'Fueling record deleted successfully.' );
        }
    public function finance_get_page()
        {
            $fuels = PermanentFuelModel:: select('vehicle_id','fueling_id','driver_id','month','year','finance_approved_by')
                                            ->distinct()
                                            ->latest()
                                            ->get();
            return view('Fuelling.financeApprove',compact('fuels'));
        }
    //finance fetch
    public function finance_fetch()
        {
            $data = PermanentFuelModel:: select('vehicle_id','fueling_id','driver_id','month','year','finance_approved_by','final_approved_by')
                                        ->distinct()
                                        ->latest()
                                        ->get();
                    
                    return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('counter', function($row) use ($data){
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })

                    ->addColumn('name', function ($row) {
                        return $row->driver->user->first_name ?? null;
                    })

                    ->addColumn('Request', function ($row) {
                        return  $row->month . '/' . $row->year;
                    })

                    ->addColumn('vehicle', function ($row) {
                        return  $row->vehicle->plate_number;
                    })

                    ->addColumn('approver', function ($row)  {
                        return $row->final_approved_by != null ? $row->finalApprover->first_name : "Not Approved Yet";
                    })

                    ->addColumn('status', function ($row)  {
                        return $row->status_check($row->fueling_id) ;
                    })

                    ->addColumn('action', function ($row) {
                        $actions =  '<button type="button" class="btn btn-info rounded-pill view-btn" data-id="' . $row->fueling_id . '"><i class="ri-eye-line"></i></button>';
                        
                        return $actions;
                    })
                    ->rawColumns(['counter','name','Request','approver','status','action'])
                    ->toJson();
        }
   // Finance Approval
    public function finance_approve(Request $request, $id)
        {
           
                //Retrieve request inputs
                $approved = $request->input('approved_reciet', []); // Default to an empty array if not provided
                $rejected = $request->input('rejected_reciet', []); // Default to an empty array if not provided

                // dd($rejected);
                $logged_user = Auth::id();
            try {
                $get_fuel_requests = PermanentFuelModel::where('fueling_id', $id)->get();
                $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                
                // Check if already approved
                if ($get_one_fuel_request->final_approved_by) {
                    return redirect()->back()->with('error_message', "Warning! You are denied the service");
                }
              
                // Get vehicle and fuel price information
                $get_vehicle = VehiclesModel::select('fuel_type')
                    ->where('vehicle_id', $get_one_fuel_request->vehicle_id)
                    ->first();
                $latest_fuel_price = FeulCosts::select('new_cost')
                    ->where('fuel_type', $get_vehicle->fuel_type)
                    ->latest()
                    ->first();
                if (!$latest_fuel_price) {
                    return redirect()->back()->with(['error_message' => 'Fuel Price is not set please Check!']);
                }
                $permanent = VehiclePermanentlyRequestModel::select('vehicle_request_permanent_id', 'fuel_quata', 'feul_left_from_prev')
                    ->where('vehicle_id', $get_one_fuel_request->vehicle_id)
                    ->where('status', true)
                    ->first();
                // Ensure that the permanent vehicle request exists
                if (!$permanent) {
                    return redirect()->back()->with(['error_message' => 'No active permanent vehicle request found for this driver and vehicle.']);
                }

                // Process fuel requests
                $number_of_attachment = $get_fuel_requests->count();
                $check_reject = 0;
                DB::beginTransaction(); // Begin a transaction
                foreach ($get_fuel_requests as $fuel_request) {
                    if (in_array($fuel_request->make_primary, $approved)) {
                        // Approve request
                        // dd('here');
                        $fuel_request->finance_approved_by = $logged_user;
                        $fuel_request->accepted = true;
                       
                        $fuel_request->save();

                        $check_reject++;

                    } elseif (array_key_exists($fuel_request->make_primary, $rejected)) {
                        // Check for rejection reason
                       
                        if (empty($rejected[$fuel_request->make_primary])) {
                            return redirect()->back()->with('error_message', "Write Reason For Rejection!");
                        }
                        
                        // Reject request
                        
                        $fuel_request->finance_approved_by = $logged_user;
                        $fuel_request->reject_reason = $rejected[$fuel_request->make_primary];
                        $fuel_request->save();
                        
                    } else {
                        // Ensure all receipts are acted upon
                        // dd('test check');
                        if (!$fuel_request->accepted && !$fuel_request->reject_reason) {
                            return redirect()->back()->with('error_message', "Take action on all attached receipts.");
                        }

                        $check_reject++;
                    }
                }
                // dd('test check');
                // Final approval
                if ($check_reject == $number_of_attachment) {
                    // dd('test check q');
                    foreach ($get_fuel_requests as $fuel_request) {
                        $fuel_request->final_approved_by = $logged_user;
                        $fuel_request->one_litre_price = $latest_fuel_price->new_cost;
                        $fuel_request->quata = $permanent->fuel_quata;
                        $fuel_request->save();
                    }
                    
                }
                DB::commit();
                return redirect()->back()->with('success_message', "You approved the request!");

            } 
            catch (Exception $e) 
            {
                // Handle any unexpected errors
                DB::rollBack();
                return redirect()->back()->with('error_message', "An error occurred: " . $e->getMessage());
            }
        }
    public function finance_appprove_reciet($id)
        {

            try
                {
                    $logged_user = Auth::id();
                    $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                    if($get_one_fuel_request->finance_approved_by || $get_one_fuel_request->reject_reason )
                        {
                            return redirect()->back()->with('error_message',
                                "Warning! You are denied the service",
                                );
                        }
                    $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                    //dd($get_one_fuel_request);
                    $permanent = VehiclePermanentlyRequestModel::select( 'vehicle_request_permanent_id','fuel_quata','feul_left_from_prev' )
                    // ->where( 'requested_by', $get_one_fuel_request->driver_id )
                    ->where( 'vehicle_id', $get_one_fuel_request->vehicle_id )
                    ->where( 'status', true )
                    ->first();
                    // Ensure that the permanent vehicle request exists
                    if ( !$permanent ) 
                        {
                            return back()->withErrors( [ 'error' => 'No active permanent vehicle request found for this driver and vehicle.' ] );
                        }

                        $get_one_fuel_request->setAttribute('finance_approved_by', $logged_user);
                        $get_one_fuel_request->save();
                        
                    $total_fuel = $get_one_fuel_request->sum('fuel_amount');
                    $total_from_prev = $permanent->feul_left_from_prev + $permanent->quata;
                    $left_for_next = $total_from_prev - $total_fuel;
                    if($left_for_next<0)
                        {
                            $left_for_next = 0;
                        }
                    $permanent->feul_left_from_prev = $left_for_next;
                    $permanent->save();
                    return redirect()->back()->with('success_message',
                    " You approve the Request!",
                    );
                }
            catch(Exception $e)
                {
                    return redirect()->back()->with('error_message',
                    "Warning! You are denied the service".$e,
                    );
                }
        }
     public function finance_reject(Request $request,$id)
        {
        
                $validator = Validator::make($request->all(), [
                    'reason' => 'required|string|max:500',
                ] );
            if ($validator->fails()) 
                {
                    return redirect()->back()->with('error_message',
                        $validator->errors(),
                    );
                }
            try
                {
                    $logged_user = Auth::id();
                    $get_fuel_requests = PermanentFuelModel::where('fueling_id', $id)->get();
                    $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                    if($get_one_fuel_request->finance_approved_by || $get_one_fuel_request->reject_reason )
                        {
                            return redirect()->back()->with('error_message',
                                "Warning! You are denied the service",
                                );
                        }
                    $permanent = VehiclePermanentlyRequestModel::select( 'vehicle_request_permanent_id','fuel_quata','feul_left_from_prev' )
                    ->where( 'driver_id', $get_one_fuel_request->driver_id )
                    ->where( 'vehicle_id', $get_one_fuel_request->vehicle_id )
                    ->where( 'status', true )
                    ->first();
                    // Ensure that the permanent vehicle request exists
                    if ( !$permanent ) 
                        {
                            return back()->withErrors( [ 'error' => 'No active permanent vehicle request found for this driver and vehicle.' ] );
                        }
                        DB::beginTransaction(); // Begin a transaction
                    foreach ($get_fuel_requests as $fuel_request) {
                            $fuel_request->finance_approved_by = $logged_user;
                            $fuel_request->reject_reason = $request->reason;
                            $fuel_request->save(); // Save the updated model to the database
                        }  
                        DB::commit();              
                    return redirect()->back()->with('success_message',
                    "You have successfully Rejected the Request",
                    );
                }
            catch(Exception $e)
                {
                    DB::rollBack();
                    return redirect()->back()->with('error_message',
                    "Warning! You are denied the service",
                    );
                }
        }
    public function finance_reject_single_reciet(Request $request,$id)
        {
        
                $validator = Validator::make($request->all(), [
                    'reject_reason' => 'required|string|max:500',
                ] );
                if ($validator->fails()) 
                {
                    return redirect()->back()->with('error_message',
                        $validator->errors(),
                    );
                }
            try
                {
                    $logged_user = Auth::id();
                    $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                    if($get_one_fuel_request->finance_approved_by || $get_one_fuel_request->reject_reason )
                        {
                            return redirect()->back()->with('error_message',
                                "Warning! You are denied the service",
                                );
                        }
                    $permanent = VehiclePermanentlyRequestModel::select( 'vehicle_request_permanent_id','fuel_quata','feul_left_from_prev' )
                    ->where( 'driver_id', $get_one_fuel_request->driver_id )
                    ->where( 'vehicle_id', $get_one_fuel_request->vehicle_id )
                    ->where( 'status', true )
                    ->first();
                    // Ensure that the permanent vehicle request exists
                    if ( !$permanent ) 
                        {
                            return back()->withErrors( [ 'error' => 'No active permanent vehicle request found for this driver and vehicle.' ] );
                        }
                        $get_one_fuel_request->finance_approved_by = $logged_user;
                        $get_one_fuel_request->reject_reason = $request->reason;
                        $get_one_fuel_request->save(); // Save the updated model to the database
                    return redirect()->back()->with('success_message',
                    "You have successfully Rejected the this reciet",
                    );
                }
            catch(Exception $e)
                {
                    return redirect()->back()->with('error_message',
                    "Warning! You are denied the service",
                    );
                }
        }
}
