<?php

namespace App\Http\Controllers\Mentenance;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle\MaintenancesModel;
use App\Models\Vehicle\VehiclesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; 
use App\Models\Vehicle\InspectionModel;
use Carbon\Carbon;
class MentenanceController extends Controller
{
    public function displayMaintenanceRequestPage()
    {
        $id = Auth::id();
        $vehicle = VehiclesModel::all();
        return view("Maintenance.index",compact('vehicle'));
    }

    public function RequestMaintenance(Request $request) 
    { 
            $validator = Validator::make($request->all(), [
                'maintenance_type' => 'required|string|max:1000',
                'vehicle'=>'required|uuid|exists:vehicles,vehicle_id',
                'driver_inspection'=>'required|string|max:1000',
                'milage'=>'required|integer',
            ],[
                'maintenance_type.required' => 'Maintenance Type is required',
                'vehicle.required' => 'Vehicle is required',
                'vehicle.exists' => 'Vehicle does not exist',
                'driver_inspection.required' => 'Driver Inspection is required',
                'milage.required' => 'Milage is required',
            ]); 
            if ($validator->fails()) {
                $errorMessages = $validator->errors()->all();
                $errorString = collect($errorMessages)->implode(' ');
                return back()->with('error_message', $errorString);
            }           
            $id = Auth::id();
            try
                {
             $maintenance_request = new MaintenancesModel;
              $maintenance_request->requested_by=$id;
              $maintenance_request->vehicle_id=$request->vehicle;
              $maintenance_request->maintenance_type=$request->maintenance_type;
              $maintenance_request->milage=$request->milage;
              $maintenance_request->drivers_inspection=$request->driver_inspection;
              $maintenance_request->save();
             
                    return  back()->with('success_message', 'Maintenance Requested Successfully.');

                }
            catch (Exception $e) 
                {
                  return redirect()->back()->with('error_message',
                             "Sorry, Something went wrong",
                        );
                }
    }
// this is a datatable that fetch maintenance request

    public function FetchMaintenanceRequest(Request $request){
        $id = Auth::id(); 

        $data_drawer_value = $request->input('customDataValue');

        if($data_drawer_value == 1){
            $data = MaintenancesModel::where('requested_by', $id)->latest()->get();
        }

        if($data_drawer_value == 2){
            $data = MaintenancesModel::with('vehicle')
            ->get();
        }

        if($data_drawer_value == 3){
            $data = MaintenancesModel::whereNotNull('approved_by')->where('maintenance_status', 'in_progress')
            ->with('vehicle')
            ->get();
        }
        
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

        ->addColumn('requestedBy', function ($row) {
            return $row->requestedBy->first_name . ' ' .$row->requestedBy->last_name;
        })

        ->addColumn('type', function ($row) {
            return $row->maintenance_type;
        })

        ->addColumn('status', function ($row) {
            return $row->maintenance_status;
        })

        ->addColumn('actions', function ($row) use ($data_drawer_value) {
            $actions ='';
            if($data_drawer_value == 1){
            $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn"  title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
            $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->maintenance_id. '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
            }

            if($data_drawer_value == 2){
                $actions = '<button type="button" class="btn btn-info rounded-pill"> <i class="ri-eye-line"></i> </button>';
                if($row->approved_by == null){
                $actions .= '<button  type="button" class="btn btn-primary rounded-pill accept-btn" data-id="' . $row->maintenance_id. '"  title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                $actions .= '<button type="button" class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->maintenance_id. '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                }
            }
            if($data_drawer_value == 3){
                $actions = '<button type="button" class="btn btn-info rounded-pill"> <i class="ri-eye-line"></i> </button>';
                
                $actions .= '<button  type="button" class="btn btn-primary rounded-pill reject-btn" data-id="' . $row->maintenance_id. '"  title="Accept"><i class="ri-checkbox-circle-line"></i></button>';
                // $actions .= '<button type="button" class="btn btn-danger rounded-pill " data-id="' . $row->maintenance_id. '" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Reject"><i class=" ri-close-circle-fill"></i></button>';
                
            }
            return $actions;
        })

        ->rawColumns(['actions','vehicle','type','status','counter','requestedBy'])
        ->toJson();

    }

    public function displayRequestForSimirit()
    {
        $id = Auth::id();
        $requested = MaintenancesModel::whereNull('sim_approved_by')
        ->where('maintenance_status', 'in_progress')->with('vehicle')
        ->get();
        return view("Maintenance.simirit_request",compact('requested','vehicle'));
    }
    public function displayRequestForApprover()
     {
            $id = Auth::id();

            return view("Maintenance.approver_request");
        }

    public function approver_approval(Request $request)
     {

        $validator = Validator::make($request->all(), [
            'maintenance_id'=>'required|exists:maintenances,maintenance_id',
            'maintenance_status'=>'required|in:approved',
            ],
            [
             'maintenance_id.required' => 'Maintenance Request is required',
             'maintenance_id.exists' => 'Maintenance Request does not exist',
             'maintenance_status.required' => 'Request status is required.',
            ]);
            if ($validator->fails()) {

                return redirect()->back()->with('error_message',
                $validator->errors(),
                );
            }
            try{         
            $vehicle_id = MaintenancesModel::where('maintenance_id',$request->maintenance_id)->first();
            $inspect = $vehicle_id->vehicle_id;
          
            $inspection = InspectionModel::where('vehicle_id',$inspect)->latest()->first();
            $taking_inspection = $inspection->inspection_id;
            $approver_id = Auth::id();

            $update_maintenance = MaintenancesModel::where('maintenance_id',$request->maintenance_id)
            ->update([
                    'maintenance_status'=>'in_progress',
                    'approver_rejection_reason' => $request->rejection_reason ?? null,
                    'taking_inspection' => $taking_inspection,
                    'approved_by' => $approver_id,
            ]);
            
           return redirect()->back()->with('success_message',
                        "Maintenance Request Approved Successfully.",
                   );
        }
           catch (Exception $e) 
           {
               DB::rollBack();
             return redirect()->back()->with('error_message',
                        "Sorry, Something went wrong",
                   );
              }
     }
    public function approver_rejection(Request $request)
     {
        
        $validator = Validator::make($request->all(), [
            'maintenance_id'=>'required|exists:maintenances,maintenance_id',
            'maintenance_status'=>'required|in:rejected',
            'approver_rejection_reason'=>'required|string|max:1000',
            ],
            [
             'maintenance_id.required' => 'Maintenance Request is required',
             'maintenance_id.exists' => 'Maintenance Request does not exist',
             'maintenance_status.required' => 'Request status is required.',
             'approver_rejection_reason.required' => 'Approver Rejection Reason is required.',
             
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error_message',
                        $validator->errors(),
                   );
                
            }
            try{        
                $vehicle_id = MaintenancesModel::where('maintenance_id',$request->maintenance_id)->first();
                $inspect = $vehicle_id->vehicle_id;
              
                $inspection = InspectionModel::where('vehicle_id',$inspect)->latest()->first();
                $taking_inspection = $inspection->inspection_id;
               
            $approver_id = Auth::id();
            
        $update_maintenance = MaintenancesModel::where('maintenance_id',$request->maintenance_id)
        ->update([
                  'maintenance_status'=>'rejected',
                  'approver_rejection_reason' => $request->rejection_reason,
                  'taking_inspection' => $taking_inspection,
                  'approved_by' => $approver_id,
           ]);
         
           return redirect()->back()->with('success_message',
                        "Maintenance Request Rejected",
                   );
        }
           catch (Exception $e) 
           {
               DB::rollBack();
             return redirect()->back()->with('error_message',
                        "Sorry, Something went wrong",
                   );
              }
      }

    public function displayRequestForInspection(){

        $id = Auth::id();

        return view("Maintenance.Maintainer_inspection");

    }
  
    public function simirit_approval(Request $request)
      {
         $validator = Validator::make($request->all(), [
             'maintenance_id'=>'required|exists:maintenances,maintenance_id',
             'maintenance_status'=>'required|in:approved',
             ],
             [
              'maintenance_id.required' => 'Maintenance Request is required',
              'maintenance_id.exists' => 'Maintenance Request does not exist',
              'maintenance_status.required' => 'Request status is required.',
             ]);
             if ($validator->fails()) {
                 return response()->json(['errors' => $validator->errors()], 422);
             }
             try{         
             $vehicle_id = MaintenancesModel::where('maintenance_id',$request->maintenance_id)->vehicle_id;
             $taking_inspection = InspectionModel::where('vehicle_id',$vehicle_id)->latest()->inspection_id;
             $simirit_id = Auth::id();
         $update_maintenance = MaintenancesModel::where('maintenance_id',$request->maintenance_id)
         ->update([
                   'maintenance_status'=>'in_progress',
                   'approver_rejection_reason' => $request->rejection_reason ?? null,
                   'taking_inspection' => $taking_inspection,
                   'sim_approved_by' => $simirit_id,
            ]);
          
            return response()->json([
             'success' => true,
             'message' => 'Maintenance Request Approved Successfully.',
         ]); 
         }
            catch (Exception $e) 
            {
                DB::rollBack();
              return redirect()->back()->with('error_message',
                         "Sorry, Something went wrong",
                    );
               }
      } 
    public function simirit_rejection(Request $request)
      {
 
         $validator = Validator::make($request->all(), [
             'maintenance_id'=>'required|exists:maintenances,maintenance_id',
             'maintenance_status'=>'required|in:rejected',
             'simirit_rejection_reason'=>'required|string|max:1000',
             ],
             [
              'maintenance_id.required' => 'Maintenance Request is required',
              'maintenance_id.exists' => 'Maintenance Request does not exist',
              'maintenance_status.required' => 'Request status is required.',
              'approver_rejection_reason.required' => 'Approver Rejection Reason is required.',
              
             ]);
             if ($validator->fails()) {
                 return response()->json(['errors' => $validator->errors()], 422);
             }
             try{         
             $vehicle_id = MaintenancesModel::where('maintenance_id',$request->maintenance_id)->vehicle_id;
             $taking_inspection = InspectionModel::where('vehicle_id',$vehicle_id)->latest()->inspection_id;
             $sim_approved_by = Auth::id();
             
         $update_maintenance = MaintenancesModel::where('maintenance_id',$request->maintenance_id)
         ->update([
                   'maintenance_status'=>'rejected',
                   'approver_rejection_reason' => $request->rejection_reason,
                   'taking_inspection' => $taking_inspection,
                   'sim_approved_by' => $sim_approved_by,
            ]);
          
            return response()->json([
             'success' => true,
             'message' => 'Maintenance Request Rejected',
         ]); 
         }
            catch (Exception $e) 
            {
                DB::rollBack();
              return redirect()->back()->with('error_message',
                         "Sorry, Something went wrong",
                    );
               }
       }
   
     
   
   
   
    public function getElapsedTime($startDate, $endDate)
       {
           $start = Carbon::parse($startDate);
           $end = Carbon::parse($endDate);
       
           $elapsedTime = $start->diffForHumans($end);
       
           return $elapsedTime;
    } 
    public function end_maintenance(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'maintenance_id' => 'required|exists:maintenances,maintenance_id',
             'maintenance_records' => 'required|array|min:1',
             'maintenance_records.*.maintenance_start_date' => 'required|date',
             'maintenance_records.*.maintenance_end_date' => 'required|date|after:maintenance_records.*.maintenance_start_date',
             'maintenance_records.*.completed_task' => 'required|string',
             'maintenance_records.*.maintained_by' => 'required|string',
     
             'items_for_next_maintenance' => 'sometimes|array|min:1',
             'items_for_next_maintenance.*.part_type' => 'sometimes|string',
             'items_for_next_maintenance.*.measurment' => 'sometimes|string',
             'items_for_next_maintenance.*.quantity' => 'sometimes|integer|min:1',
             'items_for_next_maintenance.*.part_no' => 'sometimes|string',
     
             'amount_of_nezek' => 'sometimes|array|min:1',
             'amount_of_nezek.*.amount_of_nezek' => 'sometimes|integer|min:0',
             'amount_of_nezek.*.type_of_nezek' => 'sometimes|string',
     
             'total_maintenance_cost' => 'sometimes|array|min:1',
             'total_maintenance_cost.*.sparepart_cost' => 'sometimes|integer|min:0',
             'total_maintenance_cost.*.machine_cost' => 'sometimes|integer|min:0',
             'total_maintenance_cost.*.labor_cost' => 'sometimes|integer|min:0',
             'technician_description' => 'sometimes|string',
             'spareparts_used' => 'sometimes|array|min:1',
         ], [
             'maintenance_id.required' => 'Maintenance Request is required.',
             'maintenance_id.exists' => 'Maintenance Request does not exist.',
             'maintenance_records.required' => 'Maintenance records are required.',
             'maintenance_records.*.maintenance_start_date.required' => 'The maintenance start date is required for each record.',
             'maintenance_records.*.maintenance_end_date.after' => 'The maintenance end date must be after the start date for each record.',
             'items_for_next_maintenance.required' => 'Items for next maintenance are required.',
             'amount_of_nezek.required' => 'Amount of Nezek is required.',
             'total_maintenance_cost.required' => 'Total maintenance cost is required.',
             'technician_description.required' => 'Technician description is required.',
          ]);
              if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
                      }
                       try{
                   DB::beginTransaction();
  
                   foreach ($request->maintenance_records as $request) {
                    $maintained_vehicle = Maintained_vehicle::where('maintenance_id',$request->maintenance_id)->first();
                    $timeElapsed = $this->getElapsedTime($request['maintenance_start_date'], $request['maintenance_end_date']);
                     $maintenance_record = new Maintenance_record;
                     $maintenance_record->maintenance_start_date = $request->maintenance_record->maintenance_start_date;
                     $maintenance_record->maintenance_end_date = $request->maintenance_record->maintenance_end_date;
                     $maintenance_record->completed_task = $request->maintenance_record->completed_task;
                     $maintenance_record->time_elapsed = $time_elapsed;
                     $maintenance_record->maintained_by = $request->maintenance_record->maintained_by;
                     $maintenance_record->maintained_vehicle_id = $maintained_vehicle->maintained_vehicle_id;
                     $maintenance_record->save();
                }
                foreach ($request->items_for_next_maintenance as $request) {
                    $maintained_vehicle = Maintained_vehicle::where('maintenance_id',$request->maintenance_id)->first();
                    $items_for_next_maintenance = new Items_for_next_maintenance;
                    $items_for_next_maintenance->part_type = $request->items_for_next_maintenance->part_type;
                    $items_for_next_maintenance->measurment = $request->items_for_next_maintenance->measurment;
                    $items_for_next_maintenance->quantity = $request->items_for_next_maintenance->quantity;
                    $items_for_next_maintenance->part_no = $request->items_for_next_maintenance->part_no;
                    $items_for_next_maintenance->maintained_vehicle_id = $maintained_vehicle->maintained_vehicle_id;
                    $items_for_next_maintenance->save();
                }
                foreach ($request->amount_of_nezek as $request) {
                    $maintained_vehicle = Maintained_vehicle::where('maintenance_id',$request->maintenance_id)->first();
                    $amount_of_nezek = new Amount_of_nezek;
                    $amount_of_nezek->amount_of_nezek = $request->amount_of_nezek->amount_of_nezek;
                    $amount_of_nezek->type_of_nezek = $request->amount_of_nezek->type_of_nezek;
                    $amount_of_nezek->maintained_vehicle_id = $maintained_vehicle->maintained_vehicle_id;
                    $amount_of_nezek->save();
                }
                foreach ($request->total_maintenance_cost as $request) {
                    $maintained_vehicle = Maintained_vehicle::where('maintenance_id',$request->maintenance_id)->first();
                    $total_cost = $request->total_maintenance_cost->total->sparepart_cost + $request->total_maintenance_cost->labor_cost + $request->total_maintenance_cost->machine_cost;
                    $total_maintenance_cost = new Total_maintenance_cost;
                    $total_maintenance_cost->sparepart_cost = $request->total_maintenance_cost->sparepart_cost;
                    $total_maintenance_cost->machine_cost = $request->total_maintenance_cost->machine_cost;
                    $total_maintenance_cost->labor_cost = $request->total_maintenance_cost->labor_cost;
                    $total_maintenance_cost->total_cost = $total_cost;
                    $total_maintenance_cost->maintained_vehicle_id = $maintained_vehicle->maintained_vehicle_id;
                    $total_maintenance_cost->save();
                }
                $maintained_vehicle = Maintained_vehicle::where('maintenance_id',$request->maintenance_id)
                ->update([
                    'technician_description'=>$request->technician_description,
                    'spareparts_used'=>$request->spareparts_used,
                ]);
                $maintained_vehicle = MaintenancesModel::where('maintenance_id',$request->maintenance_id)
                ->update([
                    'maintenance_status'=>'completed',
                ]);
                DB::commit();
        }
        catch (Exception $e) 
        {
            DB::rollBack();
          return redirect()->back()->with('error_message',
                     "Sorry, Something went wrong",
                );
        }
    } 
    public function deleteRequest(Request $request)
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

        // Check if the request is that of this users
        $id = $request->input('request_id');
        $user_id = Auth::id();
        try 
            {
                $Maintenance_Request = MaintenancesModel::findOrFail($id);
                if($Maintenance_Request->requested_by != $user_id)
                    {
                        return redirect()->back()->with('error_message',
                                 "Warning! You are denied the service.",
                            );

                    }
                if($Maintenance_Request->approved_by)
                    {
                        return redirect()->back()->with('error_message',
                                 "Warning! You are denied the service.",
                            );
                        
                    }
                    
                $Maintenance_Request->delete();
                return redirect()->back()->with('success_message',
                                 "Request Successfully deleted",
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
}