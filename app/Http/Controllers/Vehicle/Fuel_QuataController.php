<?php

namespace App\Http\Controllers\Vehicle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Vehicle\Fuel_QuataModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Support\Facades\Validator;
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
            // Validate the request
            $validation = Validator::make($request->all(), [
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                'Fuel_Quota' => 'required|integer|min:0',
            ]);

            if ($validation->fails()) {
                return redirect()->back()->with('error_message', $validation->errors());
            }

            $logged_user = Auth::id();
            $today = \Carbon\Carbon::today();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today);

            DB::beginTransaction(); // Begin a transaction
            try {
                // Fetch the vehicle
                $the_vehicle = VehiclesModel::find($request->vehicle_id);

                if (!$the_vehicle) {
                    return redirect()->back()->with('error_message', 'Vehicle not found.');
                }

                $current_quota = $the_vehicle->fuel_amount;
                $new_quota = $request->Fuel_Quota;

                // Create a fuel quota record
                Fuel_QuataModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'old_quata' => $current_quota,
                    'new_quata' => $new_quota,
                    'changed_by' => $logged_user,
                    'created_at' => $ethiopianDate,
                ]);

                // Update the vehicle's fuel amount
                $the_vehicle->fuel_amount = $new_quota;
                $the_vehicle->save();

                // Update the permanent fuel quota if it exists
                $permanent_request = VehiclePermanentlyRequestModel::where('vehicle_id', $request->vehicle_id)
                    ->where('status', 1)
                    ->first();

                if ($permanent_request) {
                    $permanent_request->fuel_quata = $new_quota;
                    $permanent_request->save();
                }
                DB::commit(); // Commit the transaction

                return redirect()->back()->with('success_message', "The Fuel Quota was successfully updated.");
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback the transaction on error
                return redirect()->back()->with('error_message', 'An error occurred while updating the fuel quota: ' . $e->getMessage());
            }
        }

    // Update an existing fuel quota record
    public function update(Request $request, $id)
        {
            
            $fuelQuata = Fuel_QuataModel::findOrFail($id);
           // dd($fuelQuata);
            $validation = Validator::make($request->all(),[
                'fuel_quata_id' => 'required|uuid|exists:fuel_quatas,fuel_quata_id',
                'new_quata' => 'required|integer',
          
            ]);
            if ($validation->fails()) 
            {
               return redirect()->back()->with('error_message',
                         $validation->errors(),
                    );
            }

            // $the_vehicle = $fuelQuata->vehicle_id;
           
            $the_vehicle = VehiclesModel::find($fuelQuata->vehicle_id);
           
            $fual_quata = $the_vehicle->fuel_amount;
            
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


            // $get_permananet = VehiclePermanentlyRequestModel::select('fuel_quata')->where('vehicle_id',$request->vehicle_id)->where('status',1)->first();
            // if($get_permananet)
            // {
            //     $get_permananet->fuel_quata = $request->Fuel_Quota;
            //     $get_permananet->save();
            // }
        }
}
