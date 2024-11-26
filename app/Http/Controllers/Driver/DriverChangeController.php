<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use App\Models\Driver\DriverChangeModel as DriverDriverChangeModel;
use App\Models\Driver\DriversModel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Vehicle\InspectionModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DriverChangeController extends Controller {
    // Driver change Page
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function driver_change_page() {
        $vehicles = VehiclesModel::all();
        $drivers = DriversModel::all();
        $driverChange = DriverDriverChangeModel::all();
    
        return view( 'Driver.switch', compact( 'vehicles', 'drivers', 'driverChange' ) );
    }
    // Store a new Driver Change

    public function store( Request $request ) {
       
        $validator = Validator::make( $request->all(), [
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            'driver' => 'required|uuid|exists:drivers,driver_id',
            // 'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [ 'errors' => $validator->errors() ], 422 );
        }
        //dd( $request->vehicle_id );
        $vehicle_info = VehiclesModel::findOrFail( $request->vehicle_id );
        $former_driver_id = $vehicle_info->driver_id;
        
        $logged_user = Auth::id();
        $inspection = InspectionModel::select( 'inspection_id' )->where( 'vehicle_id', $request->vehicle_id )->latest()->first();
        if(!$inspection)
           {
            return redirect()->back()->with('error_message','Inspection should be done first .',);
           }
           $today = \Carbon\Carbon::today();
           $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today);       
            DriverDriverChangeModel::create( [
            'vehicle_id' => $request->vehicle_id,
            'old_driver_id' => $former_driver_id,
             'changed_by' => $logged_user,
            'new_driver_id' => $request->driver,
            'inspection_id' => $inspection->inspection_id,
            'created_at' =>$ethiopianDate,
        ] );
        $vehicle_info->driver_id = $request->driver;
        $vehicle_info->save();
        $the_driver = DriversModel::find($request->driver);
        $the_vehicle = VehiclesModel::find($request->vehicle_id);
        $user = User::find($the_driver->user_id);
        $message = "Vehicle with $the_vehicle->plate_number plate number is assigned to you, click here to see its detail";
        $subject = "Vehicle Assigned";
        $url = "{{ route('driver.requestPage') }}";
        $user->NotifyUser($message,$subject,$url);
        return redirect()->back()->with('success_message','Driver Change Successfully Requested .',);
    }
    // Get a specific Driver Change

    public function show( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id'
        ] );
        if ( $validator->fails() ) {
            return response()->json( [ 'success' => false,
            'message' => 'Warning! You are denied the service' ], 422 );
        }
        $driverChange = DriverDriverChangeModel::findOrFail( $request->request_id );
        return response()->json( [
            'success' => true,
            'data' => $driverChange,
        ] );
    }
    // Update a Driver Change

    public function update( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            'new_driver_id' => 'required|uuid|exists:drivers,id',
            'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'success' => false,
                'message' => 'Warning! You are denied the service',
            ] );
        }
        $driverChange = DriverDriverChangeModel::findOrFail( $request->request_id );
        if ( $driverChange->driver_accepted == true ) {
            return response()->json( [
                'success' => false,
                'message' => 'Warning! You are denied the service',
            ] );
        }
        $driverChange->update( $request->all() );
        // return redirect()->back()->with('success_message','Driver change successfully updated.',);
        return response()->json( [
            'success' => true,
            'message' => 'Driver change successfully updated',
            'data' =>$driverChange,
        ] );
    }
    // Delete a Driver Change

    public function destroy( Request $request, $request_id ) {
        $validator = Validator::make( [ 'request_id' => $request_id ], [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id'
        ] );
        if ( $validator->fails() ) {
            return response()->json( [ 'success' => false,
            'message' => 'Warning! You are denied the service' ], 422 );
        }
        $driverChange = DriverDriverChangeModel::findOrFail( $request->request_id );
        if ( $driverChange->driver_accepted == true ) {
            return response()->json( [
                'success' => false,
                'message' => 'Warning! You are denied the service',
            ] );
        }
        if ( $driverChange->driver_accepted == true ) {
            return response()->json( [
                'success' => false,
                'message' => 'Warning! You are denied the service',
            ] );
        }
        $driverChange->delete();
        return redirect()->back()->with('success_message','Driver change deleted successfully.',);
    }
    public function driver_get_request()
        {
            $logged_user = Auth::id();
            // dd($logged_user);
            $Driver = DriversModel::where('user_id', $logged_user)->first();
            $driver_id = $Driver->driver_id ?? null ;
            // dd($driver_id);
            $get_request = DriverDriverChangeModel::where('new_driver_id',$driver_id)->latest()->get();
            // dd($get_request);
            // return response()->json(['my_request'=>$get_request]);
            return view( 'Driver.acceptance', compact( 'get_request' ) );
        }
    public function driver_accept(Request $request)
        {
            $validator = Validator::make( $request->all(), [
                'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
            ] );
            if ( $validator->fails() ) {
                return response()->json( [ 'success' => false,
                'message' => 'Warning! You are denied the service' ], 422 );
            }
            $logged_user = Auth::id();
            $get_request = DriverDriverChangeModel::find($request->request_id);
            if($get_request->new_driver != $logged_user || !$get_request->driver_accepted || !$get_request->driver_reject_reason)
                {
                    return response()->json(['error_message'=>"Warning! You are denied the service"]);
                }
            $get_request->driver_accepted = $logged_user;
            $get_request->save();
            $user = User::find($get_request->changed_by);
            $driver_name = $get_request->newDriver->user->first_name;
            $plate_number = $get_request->vehicle->plate_number;
            $message = "$driver_name accepted that he is assigned to vehicle with $plate_number plate number, click here to see its detail";
            $subject = "Driver Assignment";
            $url = "{{ route('driver.switch') }}";
            $user->NotifyUser($message,$subject,$url);
            return response()->json(['success_message'=>"Vehicle Successfully Transfered to you"]);
        }
    public function driver_reject(Request $request)
        {
            $validator = Validator::make( $request->all(), [
                'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
                'reason' => 'required|string'
            ] );
            if ( $validator->fails() ) {
                return response()->json( [ 'success' => false,
                'message' => 'Warning! You are denied the service' ], 422 );
            }
            $logged_user = Auth::id();
            $get_request = DriverDriverChangeModel::find($request->request_id);
            if($get_request->new_driver != $logged_user || !$get_request->driver_accepted || !$get_request->driver_reject_reason)
                {
                    return response()->json(['error_message'=>"Warning! You are denied the service"]);
                }
            $get_request->driver_accepted = $logged_user;
            $get_request->driver_reject_reason = $request->reason;
            $get_request->save();
            $user = User::find($get_request->changed_by);
            $driver_name = $get_request->newDriver->user->first_name;
            $plate_number = $get_request->vehicle->plate_number;
            $message = "$driver_name rejected that he is assigned to vehicle with $plate_number plate number, click here to see its detail";
            $subject = "Driver Assignment";
            $url = "{{ route('driver.switch') }}";
            $user->NotifyUser($message,$subject,$url);
            return response()->json(['success_message'=>"Vehicle Successfully Transfered to you"]);
        }
}
