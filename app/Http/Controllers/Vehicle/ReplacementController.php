<?php
namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\ReplacementModel;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\GivingBackVehiclePermanently;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Andegna\DateTime;
use App\Models\Vehicle\InspectionModel;
use Carbon\Carbon;

class ReplacementController extends Controller
{
    public function ConvertToEthiopianDate($today)
    {
        $ethiopianDate = new DateTime($today);

        // Format the Ethiopian date
        $formattedDate = $ethiopianDate->format('Y-m-d');

        // Display the Ethiopian date
        return $formattedDate;
    }
    public function index()
    {
        $vehicles = VehiclesModel::get();
        $permanent = vehiclePermanentlyRequestModel::get();
        return view('Vehicle.Replacement', compact('vehicles','permanent' ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'giving_back_id' => 'required|exists:giving_back_vehicles_parmanently,giving_back_vehicle_id',
            'new_vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'permanent_id' => 'required|exists:vehicle_requests_parmanently,vehicle_request_permanent_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        

        $Vehicle_Request = GivingBackVehiclePermanently::findOrFail($request->input('giving_back_id'));
       
        $old_vehicle = VehiclePermanentlyRequestModel::findOrFail($request->input('permanent_id'));
        if($old_vehicle->status)
           {
              return redirect()->back()->with('error_message', "Your Vehicle should be returned first!",);
           }
        $the_vehicle = VehiclesModel::findOrFail($request->input('new_vehicle_id'));
           if(!$the_vehicle->status)
               {
                   return redirect()->back()->with('error_message',
                                   'Vehicle Not active.',
                                   );
               }
        $latest_inspection = InspectionModel::where('vehicle_id', $request->input('new_vehicle_id'))->latest()->first();
        if (!$latest_inspection) 
        {
            return redirect()->back()->with('error_message',
            'Fill inspection first',
            );
        }
       
        $Vehicle_Request->status = true;
        $old_vehicle_id = $old_vehicle->vehicle_id;
        $old_vehicle->vehicle_id = $request->input('new_vehicle_id');
        $old_vehicle->inspection_id = $latest_inspection->inspection_id;
        $old_vehicle->fuel_quata =  $the_vehicle->fuel_amount;
        $old_vehicle->accepted_by_requestor = null;
        $old_vehicle->status = true;
        $old_vehicle->mileage =  $the_vehicle->mileage;
        $old_vehicle->save();
        $Vehicle_Request->save();
        $id = Auth::id();
        $today = Carbon::now();
        $ethio_date = $this->ConvertToEthiopianDate($today);
        ReplacementModel::create([
            'old_vehicle_id' => $old_vehicle_id,
            'permanent_id' => $request->permanent_id,
            'register_by' =>  $id,
            'created_at' => $ethio_date
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
                            // $actions .= '<button class="btn btn-secondary rounded-pill update-btn" 
                            // data-id="' . $row->replacement_id. '" 
                            // data-new="' . $row->newVehicle->plate_number. '" 
                            // data-old="' . $row->permanentRequest->vehicle->plate_number. '" 
                            // title="edit"><i class="ri-edit-line"></i></button>';
                            // $actions .= '<button class="btn btn-danger rounded-pill reject-btn"  
                            // data-id="' . $row->replacement_id. '" 
                            // title="delete"><i class=" ri-close-circle-fill"></i></button>';
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
        {
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
