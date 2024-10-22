<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use App\Models\ParmanentFueling;
use App\Models\Vehicle\PermanentFuelModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermanentFuelController extends Controller {
    public function index() {
        $fuelings = PermanentFuelModel::all();
        return view( 'Fuelling.ParmanententRequestPage', compact( 'fuelings' ) );
    }

    public function store( Request $request ) {
        // dd($request);
        // Validate input
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|string',
            'fuiling_date.*' => 'required|date',
            'month' => 'required|string',
            'fuel_amount.*' => 'required|integer',
            'fuel_cost.*' => 'required|numeric',
            'reciet_attachment.*' => 'required|string'
        ] );
        
        if ($validator->fails()) 
        {
            return redirect()->back()->with('error_message',
                 $validator->errors(),
            );
        }
        // Get logged-in user ID
        $logged_user = Auth::id();

        // Get driver based on the logged-in user
        $get_driver = DriversModel::select( 'driver_id' )->where( 'user_id', $logged_user )->first();

        // Ensure that the driver exists
        if ( !$get_driver ) {
            return redirect()->back()->with('error_message',
            "You should be registered as driver.",
            );
        }

        $get_driver_id = $get_driver->driver_id;

        // Get permanent vehicle request associated with driver and vehicle
        $permanent = VehiclePermanentlyRequestModel::select( 'vehicle_request_permanent_id','fuel_quata','feul_left_from_prev' )
        ->where( 'driver_id', $logged_user )
        ->where( 'vehicle_id', $request->vehicle_id )
        ->where( 'status', true )
        ->first();
        // Ensure that the permanent vehicle request exists
        if ( !$permanent ) {
            return back()->withErrors( [ 'error' => 'No active permanent vehicle request found for this driver and vehicle.' ] );
        }

        $get_permanent_id = $permanent->vehicle_request_permanent_id;
        // create UUID
        $fueling_id = Str::uuid();
        // Loop through each set of fueling data
        foreach ( $request->fuel_amount as $index => $fuel_amount ) {
            $fueling = new PermanentFuelModel();
            $fueling->fueling_id = $fueling_id;
            $fueling->vehicle_id = $request->vehicle_id;
            $fueling->driver_id = $get_driver_id;
            $fueling->permanent_id = $get_permanent_id;
            $fueling->fuiling_date = $request->fuiling_date[ $index ];
            $fueling->month = $request->month;
            $fueling->fuel_amount = $fuel_amount;
            $fueling->fuel_cost = $request->fuel_cost[ $index ];
            if ( $request->hasFile( "reciet_attachment[$index]" ) ) {
                $file = $request->file( "reciet_attachment[$index]" );
                $fileName = time() . '_' . $file->getClientOriginalName();
                $storagePath = storage_path( 'app/public/vehicles/reciept' );
                if ( !file_exists( $storagePath ) ) {
                    mkdir( $storagePath, 0755, true );
                }
                $file->move( $storagePath, $fileName );
                $fueling->reciet_attachment = $fileName;
            }
            $fueling->save();
        }
        return redirect()->route( 'fuelings.index' )->with( 'success', 'Fueling records created successfully.' );
    }
    public function show( $id ) {
        $fueling = PermanentFuelModel::findOrFail( $id );
        return redirect()->back()->with('data',
        $fueling,
        );    
    }
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
            'fuiling_date.*' => 'required|date',        // Fueling date is an array
            'month' => 'required|string',
            'fuel_amount.*' => 'required|integer',      // Fuel amount is an array
            'fuel_cost.*' => 'required|numeric',        // Fuel cost is an array
            'reciet_attachment.*' => 'sometimes|file|mimes:pdf,jpg,jpeg,png' // Receipt attachment is an array, optional
        ]);
    
        // Get logged-in user ID
        $logged_user = Auth::id();
    
        // Get driver based on the logged-in user
        $get_driver = DriversModel::select('driver_id')->where('user_id', $logged_user)->first();
    
        // Ensure that the driver exists
        if (!$get_driver) {
            return back()->withErrors(['error' => 'Driver not found for the logged-in user.']);
        }
    
        $get_driver_id = $get_driver->driver_id;
    
        // Get permanent vehicle request associated with driver and vehicle
        $permanent = VehiclePermanentlyRequestModel::select('vehicle_request_permanent_id')
            ->where('driver_id', $get_driver_id)
            ->where('vehicle_id', $request->vehicle_id)
            ->where('status', true)
            ->first();
    
        // Ensure that the permanent vehicle request exists
        if (!$permanent) {
            return back()->withErrors(['error' => 'No active permanent vehicle request found for this driver and vehicle.']);
        }
    
        $get_permanent_id = $permanent->vehicle_request_permanent_id;
    
        // Fetch the existing fueling record by ID (could be the main record, e.g., $id)
        $fueling = PermanentFuelModel::findOrFail($id);
        if($fueling->driver_id != $logged_user || $fueling->finance_approved_by)
          {
                return redirect()->back()->with('error_message',
                "Warning! You are denied the service",
                );
          } 
        foreach ($request->fuel_amount as $index => $fuel_amount) {
            $fueling->vehicle_id = $request->vehicle_id;
            $fueling->driver_id = $get_driver_id;
            $fueling->permanent_id = $get_permanent_id;
            
            $fueling->fuiling_date = $request->fuiling_date[$index];  // Array for fueling date
            $fueling->month = $request->month;  // Month is the same for all records
            $fueling->fuel_amount = $fuel_amount;  // Fuel amount at this index
            $fueling->fuel_cost = $request->fuel_cost[$index];  // Fuel cost at this index
    
            if ($request->hasFile("reciet_attachment[$index]")) {
                $file = $request->file( "reciet_attachment[$index]" );
                $fileName = time() . '_' . $file->getClientOriginalName();
                $storagePath = storage_path( 'app/public/vehicles/reciept' );
                if ( !file_exists( $storagePath ) ) {
                    mkdir( $storagePath, 0755, true );
                }
                $file->move( $storagePath, $fileName );
                $fueling->reciet_attachment = $fileName;
            }
            $fueling->save();
        }
        return redirect()->route('fuelings.index')->with('success', 'Fueling records updated successfully.');
    }
    public function destroy( $id ) {
        $logged_user = Auth::id();

        // Get driver based on the logged-in user
        $get_driver = DriversModel::select( 'driver_id' )->where( 'user_id', $logged_user )->first();

        // Ensure that the driver exists
        if ( !$get_driver ) {
            return redirect()->back()->with('error_message',
            "Warning! You are denied the service",
            );
        }        
        $fueling = VehiclePermanentlyRequestModel::findOrFail( $id );
        if($fueling->driver_id != $logged_user || $fueling->finance_approved_by)
            {
                return redirect()->back()->with('error_message',
                "Warning! You are denied the service",
                );
            } 
        $fueling->delete();

        return redirect()->route( 'fuelings.index' )->with( 'success', 'Fueling record deleted successfully.' );
    }
    public function finance_get_page()
    {
        $fuels = PermanentFuelModel::latest()->get();
        return view('Fuelling.financeApprove',compact('fuels'));
    }
    // Finance Approval
    public function finance_appprove($id)
     {
        try
            {
                $logged_user = Auth::id();
                $get_fuel_requests = PermanentFuelModel::where('fueling_id', $id)->get();
                $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                if($get_one_fuel_request->finance_approved_by || $get_one_fuel_request->reject_reason )
                    {
                        return redirect()->back()->with('error_message',
                            "Warning! You are denied the service",
                            );
                    }
                $get_one_fuel_request = PermanentFuelModel::where('fueling_id', $id)->first();
                $permanent = VehiclePermanentlyRequestModel::select( 'vehicle_request_permanent_id','fuel_quata','feul_left_from_prev' )
                ->where( 'driver_id', $get_one_fuel_request->driver_id )
                ->where( 'vehicle_id', $get_one_fuel_request->vehicle_id )
                ->where( 'status', true )
                ->first();
                // Ensure that the permanent vehicle request exists
                if ( !$permanent ) 
                {
                    return back()->withErrors( [ 'error' => 'No active permanent vehicle request found for this driver and vehicle.' ] );
                }

                $get_fuel_requests->finance_approved_by = $logged_user;
                $total_fuel = $get_fuel_requests->sum('fuel_amount');
                $total_from_prev = $permanent->feul_left_from_prev + $permanent->quata;
                $left_for_next = $total_from_prev - $total_fuel;
                if($left_for_next<0)
                    {
                        $left_for_next = 0;
                    }
                $permanent->feul_left_from_prev = $left_for_next;
                $permanent->save();
                return redirect()->back()->with('success_message',
                "Warning! You are denied the service",
                );
            }
        catch(Exception $e)
            {
                return redirect()->back()->with('error_message',
                "Warning! You are denied the service",
                );
            }
     }
}
