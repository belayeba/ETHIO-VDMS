<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Fuel_QuataModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Fuel_QuataController extends Controller
{
    // List all fuel quotas
    public function index()
        {
            $fuelQuatas = Fuel_QuataModel::latest()->get();
            return response()->json($fuelQuatas);
        }
    // Show a single fuel quota
    public function show($id)
        {
            $fuelQuata = Fuel_QuataModel::findOrFail($id);
            return response()->json($fuelQuata);
        }
    // Store a new fuel quota record
    public function store(Request $request)
        {
            $request->validate([
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                'new_quata' => 'required|integer',
            ]);
            $logged_user = Auth::id();
            $the_vehicle = VehiclesModel::find($request->vehicle_id);
            $fual_quata = $the_vehicle->fuel_amount;
            $fuelQuata = Fuel_QuataModel::create([
                'vehicle_id' => $request->vehicle_id,
                'old_quata' => $fual_quata,                // Current fuel quota
                'new_quata' => $request->new_quata,        // New quota provided in request
                'changed_by' => $logged_user,              // Set to logged-in user's ID
            ]);
            $the_vehicle->fuel_amount = $request->new_quata;
            $get_permananet = VehiclePermanentlyRequestModel::select('fuel_quata')->where('vehicle_id',$request->vehicle_id)->where('status',1)->first();
            if($get_permananet)
            {
                $get_permananet->fuel_quata = $request->new_quata;
                $get_permananet->save();
            }
            $the_vehicle->save();
            return response()->json($fuelQuata, 201);
        }
    // Update an existing fuel quota record
    public function update(Request $request, $id)
        {
            $fuelQuata = Fuel_QuataModel::findOrFail($id);

            $request->validate([
                'request_id' => 'required|uuid|exists:fuel_quatas,fuel_quata_id',
                'new_quata' => 'required|integer',
            ]);
            $the_vehicle = $fuelQuata->vehicle_id;
            $fual_quata = $the_vehicle->fuel_amount;
            $fuelQuata->update($request->all());
            $the_vehicle->fuel_amount = $request->new_quata;
            $get_permananet = VehiclePermanentlyRequestModel::select('fuel_quata')->where('vehicle_id',$request->vehicle_id)->where('status',1)->first();
            if($get_permananet)
                {
                    $get_permananet->fuel_quata = $request->new_quata;
                    $get_permananet->save();
                }
            $the_vehicle->save();
            return response()->json($fuelQuata);
        }
}
