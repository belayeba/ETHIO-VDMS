<?php
namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\ReplacementModel;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReplacementController extends Controller
{
    public function index()
    {
        $vehicles = VehiclesModel::get();
        $permanent = vehiclePermanentlyRequestModel::get();
        return view('Vehicle.Replacement', compact('vehicles','permanent' ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'permanent_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $id = Auth::id();
        $check_other_replacement = ReplacementModel::select('status')->where('permanent_id',$request->permanent_id)->where('status',true)->first();
        if($check_other_replacement)
            {
                $check_other_replacement->status = false;
                $check_other_replacement->update();
            }
        $replacement = ReplacementModel::create([
            'new_vehicle_id' => $request->new_vehicle_id,
            'permanent_id' => $request->permanent_id,
            'register_by' =>  $id,
        ]);

        return redirect()->back()->with('success_message', "Successfully Replaced!",);
    }

    public function FetchReplacement()
    {
        $data = ReplacementModel::with(['newVehicle', 'permanentRequest', 'registeredBy'])->get();
                
                return datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('oldCar', function ($row) {
                    return $row->permanentRequest->vehicle->plate_number;
                })

                ->addColumn('newCar', function ($row) {
                    return $row->newVehicle->plate_number;
                })

                ->addColumn('registerBy', function ($row) {
                    return $row->registeredBy->first_name .' '.$row->registeredBy->last_name ;
                })

                ->addColumn('date', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })

                ->addColumn('actions', function ($row) {
                    $actions = '';                    

                    if ($row->reviewed_by == null) {
                        $actions .= '<button class="btn btn-secondary rounded-pill update-btn" 
                        data-id="' . $row->replacement_id. '" 
                        data-new="' . $row->newVehicle->plate_number. '" 
                        data-old="' . $row->permanentRequest->vehicle->plate_number. '" 
                        title="edit"><i class="ri-edit-line"></i></button>';
                        $actions .= '<button class="btn btn-danger rounded-pill reject-btn"  
                        data-id="' . $row->replacement_id. '" 
                        title="delete"><i class=" ri-close-circle-fill"></i></button>';
                    }

                    return $actions;
                })

                ->rawColumns(['counter','oldCar','newCar','registerBy','date','actions'])
                ->toJson();
    }
    
    public function show($id)
    {
        $replacement = ReplacementModel::with(['newVehicle', 'permanentRequest', 'registeredBy'])->find($id);

        if (!$replacement) {
            return response()->json(['message' => 'Replacement not found'], 404);
        }

        return redirect()->back()->with('success_message', "Successfully Updated!",);
    }


    public function update(Request $request, $id)
        {dd($request);
            $replacement = ReplacementModel::findOrFail($id);

            if (!$replacement) {
                return response()->json(['message' => 'Replacement not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'new_vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
                'permanent_id' => 'nullable|exists:vehicle_permanently_requests,vehicle_request_permanent_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $replacement->update($request->only(['new_vehicle_id', 'permanent_id']));

            return response()->json($replacement);
        }


    public function destroy($id)
        {
            $replacement = ReplacementModel::find($id);

            if (!$replacement) {
                return response()->json(['message' => 'Replacement not found'], 404);
            }

            $replacement->delete();

            return redirect()->back()->with('success_message', "Successfully Deleted!");
        }
}
