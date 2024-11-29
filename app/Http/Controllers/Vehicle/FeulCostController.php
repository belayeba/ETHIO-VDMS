<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Fuel_QuataModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use App\Models\Vehicle\FeulCosts;

class FeulCostController extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
        {
            $this->dailyKmCalculation = $dailyKmCalculation;
        }
    // List all fuel quotas
    public function index()
        {
            $fuelCosts = FeulCosts::latest()->get();
            return view( 'Fuelling.cost', compact( 'fuelCosts') );
        }
    // Show a single fuel quota
    public function show($id)
        {
            $fuelQuata = FeulCosts::findOrFail($id);
            return response()->json($fuelQuata);
        }
    // Store a new fuel quota record
    public function store(Request $request)
        {
            
            $validation = Validator::make($request->all(),[
           
                'Fuel_cost' => 'required|integer|min:0',
                'fuel_type' => 'required|string|In:Diesel,Benzene',
            ]);
            if ($validation->fails()) 
            {
               return redirect()->back()->with('error_message',
                         $validation->errors(),
                    );
            }
            $logged_user = Auth::id();
            $today = \Carbon\Carbon::today();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            FeulCosts::create([
                'new_cost' => $request->Fuel_cost,        
                'changed_by' => $logged_user,  
                'fuel_type' => $request->fuel_type,            
                'created_at' => $ethiopianDate
            ]);
            return redirect()->back()->with('success_message',
            "The Fuel Cost Changed successfully",
           );
        }
}
