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
class InspectionController extends Controller
{
    public function InspectionPage()
        {
            $vehicle = VehiclesModel::all();
            $parts = VehiclePart::all();
            $inspections = InspectionModel::select('inspection_id','vehicle_id', 'inspected_by', 'inspection_date')
                ->distinct()
                ->orderBy('inspection_date', 'desc')
                ->get();
// dd($inspections);
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
            $damageDescriptions = $request->input('damage_descriptions', []);
            DB::transaction(function () use ($inspectionId, $vehicleId, $inspectedBy, $inspectionDate, $parts, $damagedParts, $damageDescriptions) {
                foreach ($parts as $partId => $partName) {
                    InspectionModel::create([
                        'inspection_id' => $inspectionId,
                        'vehicle_id' => $vehicleId,
                        'inspected_by' => $inspectedBy,
                        'part_name' => $partName,
                        'is_damaged' => $damagedParts[$partId],
                        'damage_description' => $damageDescriptions[$partId],
                        'inspection_date' => $inspectionDate,
                    ]);
                  

                }

            });
        
            return response()->json(['status' => 'success', 'message' => 'Inspection saved successfully']);
        }
        // Show a specific inspection
    public function showInspection($inspectionId)
        {
            $inspection = InspectionModel::where('inspection_id', $inspectionId)->get();
        
            if ($inspection->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Inspection not found'], 404);
            }
        
            return response()->json(['status' => 'success', 'data' => $inspection]);
        }
     public function showInspectionbyVehicle($vehicle_id)
        {
            try
                {
                    $inspection = InspectionModel::where('vehicle_id', $vehicle_id)->latest()->first();
                
                    if ($inspection->isEmpty()) {
                        return response()->json(['status' => 'error', 'message' => 'Inspection not found'], 404);
                    }
                
                    return response()->json(['status' => 'success', 'data' => $inspection]);
                }
            catch(Exception $e)
            {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 404);

            }
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
