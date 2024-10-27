<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\InspectionModel;
use App\Models\Vehicle\VehiclePart;
use App\Models\Vehicle\VehiclesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;

class InspectionController extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function InspectionPage()
        {
            $vehicle = VehiclesModel::all();
            $parts = VehiclePart::all();
            $inspections = InspectionModel::select('inspection_id','vehicle_id', 'inspected_by', 'inspection_date')
                ->distinct()
                ->orderBy('inspection_date', 'desc')
                ->get();
            //  dd($inspections);
            return view('Vehicle.Inspection', compact('inspections','parts','vehicle'));
        }
        //Insert Data
    public function storeInspection(Request $request)
        {
           // dd($request);
            $rules = [
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                'parts' => 'required|array',
                'parts.*' => 'required|uuid|exists:vehicle_parts,vehicle_parts_id',
                'damaged_parts' => 'nullable|array',
                'damaged_parts.*' => 'required|boolean',
                'damage_descriptions' => 'nullable|array',
                'damage_descriptions.*' => 'string|nullable',
                'inspection_image' => 'nullable|file|mimes:pdf,jpg,jpeg',
            ];
            // 
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) 
            {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            $inspectionId = Str::uuid();
            $vehicleId = $request->input('vehicle_id');
            $inspectedBy = $request->user()->id;
            $inspectionDate = now();
        
            $parts = $request->input('parts');
            $damagedParts = $request->input('damaged_parts', []);
            $fileinspection = '';    
            if ( $request->hasFile( 'inspection_image' ) ) {
                $file = $request->file( 'inspection_image' );
                $storagePath = storage_path( 'app/public/vehicles/Inspections' );
                if ( !file_exists( $storagePath ) ) {
                    mkdir( $storagePath, 0755, true );
                }
    
                $fileinspection = time() . '_' . $file->getClientOriginalName();
                $file->move( $storagePath, $fileinspection );
            }
            $damageDescriptions = $request->input('damage_descriptions', []);
            DB::transaction(function () use ($inspectionId, $vehicleId, $inspectedBy, $inspectionDate, $parts, $damagedParts, $damageDescriptions,$fileinspection) {
                $today = \Carbon\Carbon::today();
                $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
                foreach ($parts as $partId => $partName) {
                    InspectionModel::create([
                        'inspection_id' => $inspectionId,
                        'vehicle_id' => $vehicleId,
                        'inspected_by' => $inspectedBy,
                        'part_name' => $partName,
                        // 'inspection_image' => $fileinspection,
                        'is_damaged' => $damagedParts[$partId],
                        'damage_description' => $damageDescriptions[$partId],
                        'inspection_date' => $inspectionDate,
                        'created_at' => $ethiopianDate
                    ]);
                }

            });
        
            return response()->json(['status' => 'success', 'message' => 'Inspection saved successfully']);
        }
        // Show a specific inspection
    public function showInspection(Request $request)
        {
            try
            {
                $inspectionId = $request->input('id');
                $inspection = InspectionModel::where('inspection_id', $inspectionId)->get();
            
                if ($inspection->isEmpty()) {
                    return response()->json(['status' => 'error', 'message' => 'Inspection not found'], 404);
                } 
                $latest_inspection = InspectionModel::with('inspector:id,first_name','part:vehicle_parts_id,name')
                ->select('inspection_id','inspected_by','part_name','created_at','is_damaged','inspection_image','damage_description')
                ->where('inspection_id', $inspectionId)
                ->get()                   //dd($inspection->isEmpty());
                ->map(function ($inspection) {
                    return [
                        'inspection_id'      => $inspection->inspection_id,
                        'inspected_by'       => $inspection->inspector->first_name,
                        'part_name'          => $inspection->part->name,
                        'created_at'         => $inspection->created_at,
                        'is_damaged'         => $inspection->is_damaged,
                        'image_path'         => $inspection->inspection_image,
                        'damage_description'  => $inspection->damage_description,
                    ];
                });

                return response()->json(['status' => 'success', 'data' => $latest_inspection]);
            }
            catch(Exception $e)
                {
                    return response()->json(['status' => 'error', 'message' => "Sorry, Something Went Wrong"], 404);
                }
        }
    public function showInspectionbyVehicle(Request $request)
        {
            try
                {
                    $vehicle_id = $request->input('id');
                    $inspection = InspectionModel::select('inspection_id')->where('vehicle_id', $vehicle_id)->latest()->first();
                    // dd( $inspection);
                    $inspection_id = $inspection->inspection_id;
                    // dd($inspection_id);

                    $latest_inspection = InspectionModel::with('inspector:id,first_name','part:vehicle_parts_id,name')
                    ->select('inspection_id','inspected_by','part_name','created_at','is_damaged','inspection_image','damage_description')
                    ->where('inspection_id', $inspection_id)
                    ->get()                   //dd($inspection->isEmpty());
                    ->map(function ($inspection) {
                        return [
                            'inspection_id'      => $inspection->inspection_id,
                            'inspected_by'       => $inspection->inspector->first_name,
                            'part_name'          => $inspection->part->name,
                            'created_at'         => $inspection->created_at,
                            'is_damaged'         => $inspection->is_damaged,
                            'image_path'         => $inspection->inspection_image,
                            'damage_description'  => $inspection->damage_description,
                        ];
                    });

                    return response()->json(['status' => 'success', 'data' => $latest_inspection]);
                }
            catch(Exception $e)
                {
                    return response()->json(['status' => 'error', 'message' => "Sorry, Something Went Wrong"], 404);
                }
        }
     public function send_photo_data($inspection_id)
        {
            $get_photo_path = InspectionModel::select('inspection_image')->where('inspection_id',$inspection_id)->first();
        }
        // List all inspection
    public function listInspections(Request $request)
        {
            $query = InspectionModel::query();
        
            if ($request->has('vehicle_id')) 
            {
                $query->where('vehicle_id', $request->input('vehicle_id'));
            }
        
            if ($request->has('inspected_by')) {
                $query->where('inspected_by', $request->input('inspected_by'));
            }
        
            $inspections = $query->latest()->get();
        
            return response()->json(['status' => 'success', 'data' => $inspections]);
        }
    public function updateInspection(Request $request, $inspectionId, $partName)
        {
            $rules = [
                'is_damaged' => 'required|boolean',
                'damage_description' => 'nullable|string',
            ];
        
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            $updated = InspectionModel::where('inspection_id', $inspectionId)
                                        ->where('part_name', $partName)
                                        ->update([
                                            'is_damaged' => $request->input('is_damaged'),
                                            'damage_description' => $request->input('damage_description'),
                                            'updated_at' => now(),
                                        ]);
        
            if ($updated) 
            {
                return response()->json(['status' => 'success', 'message' => 'Inspection updated successfully']);
            } 
            else 
            {
                return response()->json(['status' => 'error', 'message' => 'Inspection not found or not updated'], 404);
            }
        }
    public function deleteInspection($inspectionId)
        {
            $deleted = InspectionModel::where('inspection_id', $inspectionId)
                                        ->delete();
        
            if ($deleted) {
                return response()->json(['status' => 'success', 'message' => 'Inspection deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Inspection not found or not deleted'], 404);
            }
        }
        
}
