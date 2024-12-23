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
            $vehicles = VehiclesModel::all();
            return view( 'Route.index', compact( 'routes', 'vehicles' ) );
        }
    public function own_route() 
        {
            $id = Auth::id();
            $get_route_user =  RouteUser::where('employee_id',$id)->first();
            if($get_route_user)
              {
                 $route_id =  $get_route_user->route_id;
                 $route = Route::findOrFail($route_id)->first();
                 $assignedUserIds = RouteUser::where('route_id',$route_id)->pluck('employee_id'); // Get all user IDs already in RouteUser
                 $users = User::whereIn('id', $assignedUserIds)->get(); // Exclude these users
                 $routeUser = RouteUser::where('route_id',$route_id)->get();
                 $routeUser = $routeUser->groupBy( 'route_id' );

            // $routes = Route::get();
            // $assignedUserIds = RouteUser::pluck('employee_id'); // Get all user IDs already in RouteUser
            // $users = User::whereNotIn('id', $assignedUserIds)->get(); // Exclude these users
            // $routeUser = RouteUser::all();
            // $routeUser = $routeUser->groupBy( 'route_id' );
                 return view( 'Route.employeechange', compact( 'route', 'users', 'routeUser' ));
               }
        }
    public function displayRoute() 
        {
            $routes = Route::get();
            $assignedUserIds = RouteUser::pluck('employee_id'); // Get all user IDs already in RouteUser
            $users = User::whereNotIn('id', $assignedUserIds)->get(); // Exclude these users
            $routeUser = RouteUser::all();
            $routeUser = $routeUser->groupBy( 'route_id' );

            return view( 'Route.show', compact( 'routes', 'users', 'routeUser' ) );
        }
    public function loadAssignmentForm( $route_id ) 
        {
            $route = Route::with( [ 'routeUsers.user', 'vehicle' ] )
            ->findOrFail( $route_id );

            $users = User::all();
            $vehicles = Vehicle::all();

            return view( 'routes.assign', compact( 'route', 'users', 'vehicles' ) );
        }
    public function registerRoute( Request $request ) 
        {
            //dd( $request );
            $validator = Validator::make( $request->all(), [
                'route_name' => 'required|string',
                'driver_phone' => [ 'required', 'regex:/^(?:\+251|0)[1-9]\d{8}$/' ],
                'driver_name' =>'required|string|max:60',
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            ] );
            if ( $validator->fails() ) {
                return redirect()->back()->with('error_message','All field is required.',);
            }
            try {
            $today = \Carbon\Carbon::now();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            Route::create( [
                'route_name' => $request->route_name,
                'driver_phone' => $request->driver_phone,
                'driver_name' => $request->driver_name,
                'vehicle_id' => $request->vehicle_id,
                'registered_by' => auth()->user()->id,
                'created_at' => $ethiopianDate
            ] );
            return redirect()->back()->with('success_message','Route registered successfully.',);
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('error_message','Sorry, Something Went Wrong'.$e,);
            }
        }
    public function assignUsersToRoute( Request $request ) 
        {
            foreach ( $request->people_id as $user_id ) {
                RouteUser::create( [
                    'employee_id' => $user_id,
                    'route_id' => $request->route_id,
                    'registered_by' => auth()->user()->id,
                ] );
            }
            return redirect()->back()->with('success_message','Users assigned successfully.',);
        }
    public function updateRoute( Request $request, $route_id ) 
        {
            $validator = Validator::make( $request->all(), [
                'driver_phone' => [ 'required', 'regex:/^(?:\+251|0)[1-9]\d{8}$/' ],
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            ] );
            if ( $validator->fails() ) {
                return redirect()->back()->with('error_message','All field is required.',);
            }
            $route = Route::findOrFail( $route_id );
            RouteChange::create( [
                'route_change_id' => $route_id,
                'older_vehicle_id' => $route->vehicle_id,
                'older_driver_phone' => $route->driver_phone,
                'registered_by' => auth()->user()->id,
            ] );
            // Update driver
            if ( $request->has( 'driver_phone' ) ) {
                $route->vehilce_id = $request->vehicle_id;
                $route->driver_phone = $request->driver_phone;
                $route->update();
            }
            return redirect()->back()->with('success_message','Route  successfully Updated.',);
        }

    public function removeRoute( $route_id ) 
        {
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