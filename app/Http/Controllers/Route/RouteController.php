<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RouteManagement\Route;
use App\Models\RouteManagement\RouteUser;
use App\Models\User;
use App\Models\Vehicle\VehiclesModel as Vehicle;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use App\Models\RouteManagement\EmployeeChangeLocation;
use App\Models\RouteManagement\RouteChange;
use Exception;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    //
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function displayAllRoutes()
    {
        $routes = Route::get();
        $vehicles = VehiclesModel::whereIn('rental_type', ['morning_afternoon_minibus', '40_60'])->get();
        return view('Route.index', compact('routes', 'vehicles'));
    }
    public function own_route()
    {
        $id = Auth::id();
        $Requests = EmployeeChangeLocation::where('registered_by', auth()->id())->with('changedBy')->get();
        $get_route_user =  RouteUser::where('employee_id', $id)->first();
        $route = [];
        $routeUser = [];
        $users = [];
        $routes = Route::get();
        if ($get_route_user) {
            $route_id =  $get_route_user->route_id;
            $route = Route::findOrFail($route_id)->first();
            $assignedUserIds = RouteUser::where('route_id', $route_id)->pluck('employee_id'); // Get all user IDs already in RouteUser
            $users = User::whereIn('id', $assignedUserIds)->get(); // Exclude these users
            $routeUser = RouteUser::where('route_id', $route_id)->get();
            $routeUser = $routeUser->groupBy('route_id');
        }
        return view('Route.employeechange', compact('route', 'routes', 'users', 'routeUser', 'Requests'));
    }
    public function displayRoute()
    {
        $routes = Route::get();
        $assignedUserIds = RouteUser::pluck('employee_id'); // Get all user IDs already in RouteUser
        $users = User::whereNotIn('id', $assignedUserIds)->get(); // Exclude these users
        $routeUser = RouteUser::all();
        $routeUser = $routeUser->groupBy('route_id');

        return view('Route.show', compact('routes', 'users', 'routeUser'));
    }
    public function loadAssignmentForm($route_id)
    {
        $route = Route::with(['routeUsers.user', 'vehicle'])
            ->findOrFail($route_id);

        $users = User::all();
        $vehicles = Vehicle::all();

        return view('routes.assign', compact('route', 'users', 'vehicles'));
    }
    public function registerRoute(Request $request)
    {
        // dd( $request );
        $validator = Validator::make($request->all(), [
            'route_name' => 'required|string',
            'driver_phone' => ['required', 'regex:/^(?:\+251|0)[1-9]\d{8}$/'],
            'driver_name' => 'required|string|max:60',
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'All field is required.',);
        }
        try {
            $today = \Carbon\Carbon::now();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today);
            Route::create([
                'route_name' => $request->route_name,
                'driver_phone' => $request->driver_phone,
                'driver_name' => $request->driver_name,
                'vehicle_id' => $request->vehicle_id,
                'registered_by' => auth()->user()->id,
                'created_at' => $ethiopianDate
            ]);
            return redirect()->back()->with('success_message', 'Route registered successfully.',);
        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'Sorry, Something Went Wrong' . $e,);
        }
    }
    public function assignUsersToRoute(Request $request)
    {
        foreach ($request->people_id as $user_id) {
            RouteUser::create([
                'employee_id' => $user_id,
                'route_id' => $request->route_id,
                'registered_by' => auth()->user()->id,
            ]);
        }
        return redirect()->back()->with('success_message', 'Users assigned successfully.',);
    }
    public function updateRoute(Request $request, $route_id)
    {
        dd("coming");
        $validator = Validator::make($request->all(), [
            'driver_phone' => ['required', 'regex:/^(?:\+251|0)[1-9]\d{8}$/'],
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'All field is required.',);
        }
        $route = Route::findOrFail($route_id);
        RouteChange::create([
            'route_change_id' => $route_id,
            'older_vehicle_id' => $route->vehicle_id,
            'older_driver_phone' => $route->driver_phone,
            'registered_by' => auth()->user()->id,
        ]);
        // Update driver
        if ($request->has('driver_phone')) {
            $route->vehilce_id = $request->vehicle_id;
            $route->driver_phone = $request->driver_phone;
            $route->update();
        }
        return redirect()->back()->with('success_message', 'Route  successfully Updated.',);
    }
    public function update(Request $request, $route_id)
    {
        $user = Auth::id();
        $validator = Validator::make($request->all(), [
            'driver_phone' => ['nullable', 'regex:/^(?:\+251|0)[1-9]\d{8}$/'], // Make driver_phone nullable to allow skipping
            'vehicle_id' => 'nullable|uuid|exists:vehicles,vehicle_id', // Make vehicle_id nullable to allow skipping
            'route_name' => 'nullable|string',
            'driver_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'All fields are required.');
        }
        $route = Route::findOrFail($route_id);

        $updateData = $request->only([
            'driver_phone',
            'route_name',
            'vehicle_id',
            'driver_name'
        ]);

        // Remove null fields from the update array
        $updateData = array_filter($updateData, fn($value) => !is_null($value));
        $route->update($updateData);

        return redirect()->back()->with('success_message', 'Successfully Updated.');
    }
    public function removeRoute($route_id)
    {
        // Find the route by ID or fail if it doesn't exist
        $route = Route::findOrFail($route_id);

        // Delete the route
        // $route->delete();

        // Return a success message 
        return redirect()->back()->with('error_message', 'You cannot Delete this route.',);
    }
    public function removeUserFromRoute($id)
    {
        $routeUser = RouteUser::where('employee_id', $id)->first();

        if ($routeUser) {
            $routeUser->delete();
            return redirect()->back()->with('success_message', 'User removed from route successfully.',);
        } else {
            return redirect()->back()->with('error_message', 'User Not found',);
        }
    }
    public function removeAllUsersFromRoute($route_id)
    {
        RouteUser::where('route_id', $route_id)->delete();
        return redirect()->back()->with('success_message', 'All user removed successfullly.',);
    }
    public function updateLocation(Request $request)
    {
        $request->validate([
            'route_user_id' => 'required|exists:route_user,route_user_id',
            'location' => 'required|string|max:255'
        ]);
        $user = Auth::user();
        $employee = RouteUser::findOrFail($request->route_user_id);

        // Ensure the logged-in user can only update their own location
        if ($user->id !== $employee->employee_id) {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
        }
        // Ensure the employee can only update their location if it is 'Unkown'
        if ($employee->employee_start_location !== 'Unkown') {
            return redirect()->back()->with('error_message', 'Warning! You are denied the service.');
        }

        // Update location
        $employee->employee_start_location = $request->location;
        $employee->update();

        return redirect()->back()->with('success_message', 'Location updated Successfully',);
    }
}
