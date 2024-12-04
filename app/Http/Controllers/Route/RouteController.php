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
use Exception;

class RouteController extends Controller {
    //
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function displayAllRoutes() {
        $routes = Route::get();
        $vehicles = VehiclesModel::all();

        return view( 'Route.index', compact( 'routes', 'vehicles' ) );
    }
    public function displayRoute() {
        $routes = Route::get();
        $assignedUserIds = RouteUser::pluck('employee_id'); // Get all user IDs already in RouteUser
        $users = User::whereNotIn('id', $assignedUserIds)->get(); // Exclude these users
        $routeUser = RouteUser::all();
        $routeUser = $routeUser->groupBy( 'route_id' );

        return view( 'Route.show', compact( 'routes', 'users', 'routeUser' ) );
    }
    public function loadAssignmentForm( $route_id ) {
        $route = Route::with( [ 'routeUsers.user', 'vehicle' ] )
        ->findOrFail( $route_id );

        $users = User::all();
        $vehicles = Vehicle::all();

        return view( 'routes.assign', compact( 'route', 'users', 'vehicles' ) );
    }
    public function registerRoute( Request $request ) {
        //dd( $request );
        $validator = Validator::make( $request->all(), [
            'route_name' => 'required|string',
            'driver_phone' => [ 'required', 'regex:/^(?:\+251|0)[1-9]\d{8}$/' ],
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->with('error_message','All field is required.',);
        }
        try {
        $today = \Carbon\Carbon::today();
        $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
        Route::create( [
            'route_name' => $request->route_name,
            'driver_phone' => $request->driver_phone,
            'vehicle_id' => $request->vehicle_id,
            'registered_by' => auth()->user()->id,
            'created_at' => $ethiopianDate
        ] );
        return redirect()->back()->with('success_message','Route registered successfully.',);
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error_message','Sorry, Something Went Wrong',);
        }
    }

    public function assignUsersToRoute( Request $request ) {
      
        foreach ( $request->people_id as $user_id ) {
            RouteUser::create( [
                'employee_id' => $user_id,
                'route_id' => $request->route_id,
                'registered_by' => auth()->user()->id,
            ] );
        }
        return redirect()->back()->with('success_message','Users assigned successfully.',);
    }

        public function updateRouteAssignment( Request $request, $route_id ) {
            $route = Route::findOrFail( $route_id );

        // Update driver
        if ( $request->has( 'driver_phone' ) ) {
            $route->driver_phone = $request->driver_phone;
            $route->save();
        }
        // Reassign new users
        if ( $request->user_ids ) {
            foreach ( $request->user_ids as $user_id ) {
                RouteUser::create( [
                    'employee_id' => $user_id,
                    'route_id' => $route_id,
                    'registered_by' => auth()->user()->id,
                ] );
            }
        }
        return redirect()->back()->with('success_message','Route Assignment successfull.',);
    }

        public function removeRoute( $route_id ) {
            // Find the route by ID or fail if it doesn't exist
        $route = Route::findOrFail($route_id);
    
        // Delete the route
        $route->delete();
    
        // Return a success message 
        return redirect()->back()->with('success_message','Route deleted successfully.',);
    }
    public function removeUserFromRoute($id)
    {
        $routeUser = RouteUser::where('employee_id', $id)->first();
    
        if ($routeUser) {
            $routeUser->delete();
            return redirect()->back()->with('success_message','User removed from route successfully.',);
        } else {
            return redirect()->back()->with('error_message','User Not found',);
        }
    }
    public function removeAllUsersFromRoute($route_id)
    {
        RouteUser::where('route_id', $route_id)->delete();
        return redirect()->back()->with('success_message','All user removed successfullly.',);
        }

    }