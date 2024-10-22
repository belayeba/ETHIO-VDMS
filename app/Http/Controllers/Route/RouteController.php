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
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Str;

class RouteController extends Controller {
    //

    public function displayAllRoutes() {
        $routes = Route::get();
        $vehicles = VehiclesModel::all();

        return view( 'Route.index', compact( 'routes', 'vehicles' ) );
    }

    public function displayRoute() {
        $routes = Route::get();
        $users = User::all();
        $routeUser = RouteUser::all();
        // dd( $routeUser );
        $routeUser = $routeUser->groupBy( 'route_id' );
        //$routeUser = RouteUser::with( 'user.department' )->get();

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
            return response()->json( [ 'errors' => $validator->errors() ], 422 );
        }
        $route = Route::create( [
            'route_name' => $request->route_name,
            'driver_phone' => $request->driver_phone,
            'vehicle_id' => $request->vehicle_id,
            'registered_by' => auth()->user()->id, ] );

            return response()->json( [ 'message' => 'Route registered successfully', 'route' => $route ] );
        }

        public function assignUsersToRoute( Request $request ) {
            // $route = Route::findOrFail( $route_id );

            // Assign Users to Route
            foreach ( $request->people_id as $user_id ) {
                RouteUser::create( [
                    'employee_id' => $user_id,
                    'route_id' => $request->route_id,
                    'registered_by' => auth()->user()->id,
                ] );
            }

            return response()->json( [ 'message' => 'Users assigned successfully' ] );
            return redirect()->back()->with( 'success_message',
            'Users assigned successfully.', );
        }

        public function updateRouteAssignment( Request $request, $route_id ) {
            $route = Route::findOrFail( $route_id );

            // Update driver
            if ( $request->has( 'driver_phone' ) ) {
                $route->driver_phone = $request->driver_phone;
                $route->save();
            }

            // // Remove existing users from route
            // RouteUser::where( 'route_id', $route_id )->delete();

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

            return response()->json( [ 'message' => 'Route assignments updated successfully' ] );
        }

        public function removeRoute( $route_id ) {
            // Find the route by ID or fail if it doesn't exist
        $route = Route::findOrFail($route_id);
    
        // Delete the route
        $route->delete();
    
        // Return a success message 
        return redirect()->back()->with('success_message',
        'Route deleted successfully.',);
    }

    public function removeUserFromRoute(Request $request, $route_id)
    {
        // Remove specific users from the route
        foreach ($request->user_ids as $user_id) {
            RouteUser::where('route_id', $route_id)
                    ->where('employee_id', $user_id)
                    ->delete();
        }

        return response()->json(['message' => 'Users removed from route successfully']);
    }

    public function removeAllUsersFromRoute($route_id)
    {
        RouteUser::where('route_id', $route_id)->delete();

        return response()->json(['message' => 'All users removed from route successfully' ] );
        }

    }