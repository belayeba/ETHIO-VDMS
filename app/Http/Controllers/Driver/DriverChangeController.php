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

class DriverChangeController extends Controller
{
    // Driver change Page
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function driver_change_page()
    {
        // $vehicles = VehiclesModel::all();
        $vehicles = VehiclesModel::whereIn('rental_type', ['field', 'service'])
            ->where('status', 1)
            ->get();
        $drivers = DriversModel::all();
        $driverChange = DriverDriverChangeModel::all();
        return view('Driver.switch', compact('vehicles', 'drivers', 'driverChange'));
    }
    // Store a new Driver Change

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            'driver' => 'required|uuid|exists:drivers,driver_id',
            // 'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'All field required.',);
        }
        //dd( $request->vehicle_id );
        $vehicle_info = VehiclesModel::findOrFail($request->vehicle_id);
        $former_driver_id = $vehicle_info->driver_id;

        $logged_user = Auth::id();
        $inspection = InspectionModel::select('inspection_id')->where('vehicle_id', $request->vehicle_id)->latest()->first();
        if (!$inspection) {
            return redirect()->back()->with('error_message', 'Inspection should be done first .',);
        }
        $today = \Carbon\Carbon::now();
        $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today);
        DriverDriverChangeModel::create([
            'vehicle_id' => $request->vehicle_id,
            'old_driver_id' => $former_driver_id,
            'changed_by' => $logged_user,
            'new_driver_id' => $request->driver,
            'inspection_id' => $inspection->inspection_id,
            'created_at' => $ethiopianDate,
        ]);
        $vehicle_info->driver_id = $request->driver;
        $vehicle_info->save();
        $the_driver = DriversModel::find($request->driver);
        $the_vehicle = VehiclesModel::find($request->vehicle_id);
        $user = User::find($the_driver->user_id);
        $message = "Vehicle with $the_vehicle->plate_number plate number is assigned to you, click here to see its detail";
        $subject = "Vehicle Assigned";
        $url = "driver_change/my_request";
        $user->NotifyUser($message, $subject, $url);
        return redirect()->back()->with('success_message', 'Driver Change Successfully Requested .',);
    }
    // Get a specific Driver Change

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        $driverChange = DriverDriverChangeModel::findOrFail($request->request_id);
        return response()->json([
            'success' => true,
            'data' => $driverChange,
        ]);
    }
    // Update a Driver Change

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            'new_driver_id' => 'required|uuid|exists:drivers,id',
            'inspection_id' => 'required|uuid|exists:vehicle_inspections,inspection_id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        $driverChange = DriverDriverChangeModel::findOrFail($request->request_id);
        if ($driverChange->driver_accepted == true) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        $driverChange->update($request->all());
        // return redirect()->back()->with('success_message','Driver change successfully updated.',);
        return redirect()->back()->with('success_message', 'Driver Changed Successfully',);
    }
    // Delete a Driver Change

    public function destroy(Request $request, $request_id)
    {
        $validator = Validator::make(['request_id' => $request_id], [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        $driverChange = DriverDriverChangeModel::where('driver_change_id', $request_id)->firstOrFail();
        // dd($driverChange);
        if ($driverChange->driver_accepted == true) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        $driverChange->delete();
        return redirect()->back()->with('success_message', 'Driver Chage deleted Successfully',);
    }
    public function driver_get_request()
    {
        $logged_user = Auth::id();
        // dd($logged_user);
        $Driver = DriversModel::where('user_id', $logged_user)->first();
        if (!$Driver) {
            return redirect()->back()->with(
                'error_message',
                "You Are not driver",
            );
        }
        $driver_id = $Driver->driver_id;
        // dd($driver_id);
        $get_request = DriverDriverChangeModel::where('new_driver_id', $driver_id)->latest()->get();
        // dd($get_request);
        // return response()->json(['my_request'=>$get_request]);
        return view('Driver.Acceptance', compact('get_request'));
    }
    public function driver_accept(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        $logged_user = Auth::id();
        $get_request = DriverDriverChangeModel::find($request->request_id);
        $getDriver = DriversModel::select('driver_id')->where('user_id', $logged_user)->first();
        if (!$getDriver) {
            return response()->json(['error_message' => "Warning! You are denied the service"]);
        }
        // dd($get_request->driver_accepted != 1 );
        if (($get_request->newDriver->user_id) != ($logged_user) || $get_request->driver_accepted != 0 || $get_request->driver_reject_reason != null) {
            return response()->json(['error_message' => "Warning! You are denied the service"]);
        }
        $the_vehicle = VehiclesModel::find($get_request->vehicle_id);
        $the_vehicle->driver_id = $getDriver->driver_id;
        $the_vehicle->save();
        $get_request->driver_accepted = true;
        $get_request->save();
        $user = User::find($get_request->changed_by);
        $driver_name = $get_request->newDriver->user->first_name;
        $plate_number = $get_request->vehicle->plate_number;
        $message = "$driver_name accepted that he is assigned to vehicle with $plate_number plate number, click here to see its detail";
        $subject = "Driver Assignment";
        $url = "/driver_change";
        $user->NotifyUser($message, $subject, $url);
        return redirect()->back()->with('success_message', 'Vehicle Successfully Transfered',);
    }
    public function driver_reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|uuid|exists:driver_changes,driver_change_id',
            'reason' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success_message' => false,
                'message' => 'Warning! You are denied the service'
            ], 422);
        }
        $logged_user = Auth::id();
        $get_request = DriverDriverChangeModel::find($request->request_id);
        if ($get_request->new_driver != $logged_user || !$get_request->driver_accepted || !$get_request->driver_reject_reason) {
            return response()->json(['error_message' => "Warning! You are denied the service"]);
        }
        $get_request->driver_accepted = $logged_user;
        $get_request->driver_reject_reason = $request->reason;
        $get_request->save();
        $user = User::find($get_request->changed_by);
        $driver_name = $get_request->newDriver->user->first_name;
        $plate_number = $get_request->vehicle->plate_number;
        $message = "$driver_name rejected that he is assigned to vehicle with $plate_number plate number, click here to see its detail";
        $subject = "Driver Assignment";
        $url = "driver_change/";
        $user->NotifyUser($message, $subject, $url);
        return redirect()->back()->with('success_message', 'Vehicle Transfer is rejected',);
    }
}
