<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RouteManagement\Route;
use App\Models\RouteManagement\RouteUser;
use App\Models\User;
use App\Models\Vehicle\VehiclesModel as Vehicle;

class RouteController extends Controller
{
    //
    public function displayAllRoutes()
    {
        $routes = Route::with(['routeUsers.user', 'vehicle', 'registeredBy'])
                        ->get();

        return view('routes.index', compact('routes'));
    }

    public function displayRoute($route_id)
    {
        $route = Route::with(['routeUsers.user', 'vehicle', 'registeredBy'])
                    ->findOrFail($route_id);

        return view('routes.show', compact('route'));
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
        $request->validate([
            'route_name' => 'required|string',
            'driver_phone' => 'string|nullable',
            'vehicle_id' => 'required|uuid',
        ]);

        $route = Route::create([
            'route_id' => Str::uuid(),
            'route_name' => $request->route_name,
            'driver_phone' => $request->driver_phone,
            'vehicle_id' => $request->vehicle_id,
            'registered_by' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Route registered successfully', 'route' => $route]);
    }

    public function assignDriverAndUsersToRoute(Request $request, $route_id)
    {
        $route = Route::findOrFail($route_id);

        // assign driver
        if ($request->has('driver_phone')) {
            $route->driver_phone = $request->driver_phone;
            $route->save();
        }

        // Assign Users to Route
        foreach ($request->user_ids as $user_id) {
            RouteUser::create([
                'route_user_id' => Str::uuid(),
                'employee_id' => $user_id,
                'route_id' => $route_id,
                'registered_by' => auth()->user()->id,
            ]);
        }

        return response()->json(['message' => 'Driver and users assigned successfully']);
    }

    public function updateRouteAssignment(Request $request, $route_id)
    {
        $route = Route::findOrFail($route_id);

        // Update driver
        if ($request->has('driver_phone')) {
            $route->driver_phone = $request->driver_phone;
            $route->save();
        }

        // // Remove existing users from route
        // RouteUser::where('route_id', $route_id)->delete();

        // Reassign new users
        if ( $request->user_ids) {
            foreach ($request->user_ids as $user_id) {
                RouteUser::create([
                    'route_user_id' => Str::uuid(),
                    'employee_id' => $user_id,
                    'route_id' => $route_id,
                    'registered_by' => auth()->user()->id,
                ]);
            }
        }

        return response()->json(['message' => 'Route assignments updated successfully']);
    }

    public function removeDriverFromRoute($route_id)
    {
        $route = Route::findOrFail($route_id);
        
        // Set driver_phone to null to remove the driver
        $route->driver_phone = null;
        $route->save();

        return response()->json(['message' => 'Driver removed successfully']);
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

        return response()->json(['message' => 'All users removed from route successfully']);
    }

}
