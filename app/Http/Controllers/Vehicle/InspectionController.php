<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\InspectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class InspectionController extends Controller
{
        //Insert Data
    public function storeInspection(Request $request)
        {
            $rules = [
                'vehicle_id' => 'required|uuid|exists:vehicles,vehicle_id',
                'parts' => 'required|array',
                'parts.*' => 'required|uuid|exists:vehicle_parts,vehicle_parts_id',
                'damaged_parts' => 'nullable|array',
                'damaged_parts.*' => 'uuid|exists:vehicle_parts,vehicle_parts_id',
                'damage_descriptions' => 'nullable|array',
                'damage_descriptions.*' => 'string|nullable',
            ];
        
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
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
                foreach ($parts as $partName) {
                    $isDamaged = in_array($partName, $damagedParts);
                    $damageDescription = $isDamaged && isset($damageDescriptions[$partName]) ? $damageDescriptions[$partName] : null;
        
                    InspectionModel::create([
                        'inspection_id' => $inspectionId,
                        'vehicle_id' => $vehicleId,
                        'inspected_by' => $inspectedBy,
                        'part_name' => $partName,
                        'is_damaged' => $isDamaged,
                        'damage_description' => $damageDescription,
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
        // List all inspection
    public function listInspections(Request $request)
        {
            $query = InspectionModel::query();
        
            if ($request->has('vehicle_id')) {
                $query->where('vehicle_id', $request->input('vehicle_id'));
            }
        
            if ($request->has('inspected_by')) {
                $query->where('inspected_by', $request->input('inspected_by'));
            }
        
            $inspections = $query->get();
        
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
