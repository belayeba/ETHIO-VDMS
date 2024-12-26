<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use App\Models\RouteManagement\EmployeeChangeLocation;
use App\Models\RouteManagement\Route;
use App\Models\RouteManagement\RouteUser;
use App\Models\Vehicle\VehiclePart;
use App\Models\Vehicle\VehiclesModel;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeChangeLocationController extends Controller
{
    public function ConvertToEthiopianDate($today)
        {
            $ethiopianDate = new DateTime($today);

            // Format the Ethiopian date
            $formattedDate = $ethiopianDate->format('Y-m-d');

            // Display the Ethiopian date
            return $formattedDate;
        }
    public function simiritPage()
        {
            $Requests = EmployeeChangeLocation::get();
             // $Vehicles = VehiclesModel::get();
            $Route = Route::get();
            return view('Route.ApproveLocationChange', compact('Requests','Route'));
        }
    public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'location_name' => 'required|string|max:50',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error_message','Name Required',);
            }
            $id = Auth::id();
            $get_route = RouteUser::select('route_user_id')->where('employee_id',$id)->first();
            if(!$get_route)
                {
                    $today = Carbon::now();
                    $ethio_date = $this->ConvertToEthiopianDate($today);
                    EmployeeChangeLocation::create([
                        'location_name' => $request->location_name,
                        'registered_by' =>  $id,
                        'created_at' => $ethio_date
                    ]);
                return redirect()->back()->with('success_message', "Successfully Requested!",);
                }
                $today = Carbon::now();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                EmployeeChangeLocation::create([
                    'route_id' => $get_route->route_id,
                    'location_name' => $request->location_name,
                    'registered_by' =>  $id,
                    'created_at' => $ethio_date
                ]);
                return redirect()->back()->with('success_message', "Successfully Requested!",);
        }
    // public function FetchReplacement()
    //     {
    //         $data = ReplacementModel::with(['newVehicle', 'permanentRequest', 'registeredBy'])->get();
                    
    //                 return datatables()->of($data)
    //                 ->addIndexColumn()

    //                 ->addColumn('counter', function($row) use ($data){
    //                     static $counter = 0;
    //                     $counter++;
    //                     return $counter;
    //                 })
    //                 ->addColumn('oldCar', function ($row) {
    //                     return $row->permanentRequest->vehicle->plate_number;
    //                 })

    //                 ->addColumn('newCar', function ($row) {
    //                     return $row->newVehicle->plate_number;
    //                 })

    //                 ->addColumn('registerBy', function ($row) {
    //                     return $row->registeredBy->first_name .' '.$row->registeredBy->last_name ;
    //                 })

    //                 ->addColumn('date', function ($row) {
    //                     return $row->created_at->format('d/m/Y');
    //                 })

    //                 ->addColumn('actions', function ($row) {
    //                     $actions = '';                    

    //                     if ($row->reviewed_by == null) {
    //                         $actions .= '<button class="btn btn-secondary rounded-pill update-btn" 
    //                         data-id="' . $row->replacement_id. '" 
    //                         data-new="' . $row->newVehicle->plate_number. '" 
    //                         data-old="' . $row->permanentRequest->vehicle->plate_number. '" 
    //                         title="edit"><i class="ri-edit-line"></i></button>';
    //                         $actions .= '<button class="btn btn-danger rounded-pill reject-btn"  
    //                         data-id="' . $row->replacement_id. '" 
    //                         title="delete"><i class=" ri-close-circle-fill"></i></button>';
    //                     }

    //                     return $actions;
    //                 })

    //                 ->rawColumns(['counter','oldCar','newCar','registerBy','date','actions'])
    //                 ->toJson();
    //     }
    
    public function show($id)
        {
            $replacement = ReplacementModel::with(['newVehicle', 'permanentRequest', 'registeredBy'])->find($id);

            if (!$replacement) {
                return response()->json(['message' => 'Replacement not found'], 404);
            }

            return redirect()->back()->with('success_message', "Successfully Updated!",);
        }
    public function approve_change(Request $request)
        {
            $change_request = EmployeeChangeLocation::findOrFail($request->input('request_id'));

            if (!$change_request) 
                {
                    return response()->json(['message' => 'Request not found'], 404);
                }
            $validator = Validator::make($request->all(), [
                'new_route' => 'required|exists:routes,route_id',
            ]);

            if ($validator->fails()) 
                {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
            $routeUser = RouteUser::where('employee_id', $change_request->registered_by)->first();
    
            if ($routeUser) 
                {
                    $routeUser->delete();
                    RouteUser::create( [
                        'employee_id' => $change_request->registered_by,
                        'employee_start_location'=> $change_request->location_name,
                        'route_id' => $request->new_route,
                        'registered_by' => auth()->user()->id,
                    ] );
                } 
            else 
                {
                    RouteUser::create( [
                        'employee_id' => $change_request->registered_by,
                        'employee_start_location'=> $change_request->location_name,
                        'route_id' => $request->new_route,
                        'registered_by' => auth()->user()->id,
                    ] );
                }
                $change_request->changed_by = auth()->user()->id;
                $change_request->save();
                return redirect()->back()->with('success_message','Successfully Changed',);

        }

    public function destroy($id)
        {
            $replacement = ReplacementModel::find($id);

            if (!$replacement) 
                {
                    return response()->json(['message' => 'Replacement not found'], 404);
                }
            $replacement->delete();

            return redirect()->back()->with('success_message', "Successfully Deleted!");
        }
}
