<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Fuel_QuataModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;

class Fuel_QuataController extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    // List all fuel quotas
    public function index()
        {
            $vehicles = VehiclesModel::all();
            $fuelQuatas = Fuel_QuataModel::latest()->get();
            // dd($fuelQuatas);
            return view( 'Fuelling.quota', compact( 'fuelQuatas','vehicles' ) );
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
                'Fuel_Quota' => 'required|integer',
            ]);
            $logged_user = Auth::id();
            $the_vehicle = VehiclesModel::find($request->vehicle_id);
            $fual_quata = $the_vehicle->fuel_amount;
            $today = \Carbon\Carbon::today();
           $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            $fuelQuata = Fuel_QuataModel::create([
                'vehicle_id' => $request->vehicle_id,
                'old_quata' => $fual_quata,                // Current fuel quota
                'new_quata' => $request->Fuel_Quota,        // New quota provided in request
                'changed_by' => $logged_user,              // Set to logged-in user's ID
                'created_at' => $ethiopianDate
            ]);
            $the_vehicle->fuel_amount = $request->Fuel_Quota;
            $get_permananet = VehiclePermanentlyRequestModel::select('fuel_quata')->where('vehicle_id',$request->vehicle_id)->where('status',1)->first();
            if($get_permananet)
            {
                $get_permananet->fuel_quata = $request->Fuel_Quota;
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
                'fuel_quata_id' => 'required|uuid|exists:fuel_quatas,fuel_quata_id',
                'new_quota' => 'required|integer',
            ]);
            $the_vehicle = $fuelQuata->vehicle_id;
            $fuelQuata->update($request->all());
            $get_permananet = VehiclePermanentlyRequestModel::select('fuel_quata')->where('vehicle_id',$fuelQuata->vehicle_id)->where('status',1)->first();
            if($get_permananet)
                {
                    $get_permananet->fuel_quata = $request->new_quata;
                    $get_permananet->save();
                }
            $the_vehicle->save();
            return response()->json($fuelQuata);
        }
}
