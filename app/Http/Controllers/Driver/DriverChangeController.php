<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriverChangeModel as DriverDriverChangeModel;
use App\Models\Driver\DriversModel;
use Illuminate\Http\Request;
use App\Models\Vehicle\InspectionModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DriverChangeController extends Controller {
    // Driver change Page

    public function driver_change_page() {
        $vehicles = VehiclesModel::all();
        $drivers = DriversModel::all();
        $driverChange = DriverDriverChangeModel::all();

        return view( 'Driver.switch', compact( 'vehicles', 'drivers', 'driverChange' ) );
    }
    // Store a new Driver Change

    public function store( Request $request ) {
        // dd( $request );
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
        // dd( $vehicle_info );
        $logged_user = Auth::id();
        $inspection = InspectionModel::select( 'inspection_id' )->where( 'vehicle_id', $request->vehicle_id )->latest()->first();
        // dd( $logged_user );
        $driverChange = DriverDriverChangeModel::create( [
            'vehicle_id' => $request->vehicle_id,
            'old_driver_id' => $former_driver_id,
            'changed_by' => $logged_user,
            'new_driver_id' => $request->driver,
            'inspection_id' => $inspection->inspection_id,
        ] );
        $vehicle_info->driver_id = $request->driver;
        $vehicle_info->save();
        return response()->json( [ 'Message'=>'Driver Change Successfully Requested' ], 201 );
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
        return response()->json( [ 'message' => 'Driver change deleted successfully' ] );
    }
}
