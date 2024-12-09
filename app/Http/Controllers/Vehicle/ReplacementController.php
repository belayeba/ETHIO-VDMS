<?php

namespace App\Http\Controllers\Vehicle;

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\ReplacementModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReplacementController extends Controller
{
    public function index()
    {
        $replacements = ReplacementModel::with(['newVehicle', 'permanentRequest', 'registeredBy'])->get();
        return response()->json($replacements);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'permanent_id' => 'required|exists:vehicle_permanently_requests,vehicle_request_permanent_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $id = Auth::id();
        $replacement = ReplacementModel::create([
            'new_vehicle_id' => $request->new_vehicle_id,
            'permanent_id' => $request->permanent_id,
            'register_by' =>  $id,
            'status' => false, // Default value
        ]);

        return response()->json($replacement, 201);
    }
    
    public function show($id)
    {
        $replacement = ReplacementModel::with(['newVehicle', 'permanentRequest', 'registeredBy'])->find($id);

        if (!$replacement) {
            return response()->json(['message' => 'Replacement not found'], 404);
        }

        return response()->json($replacement);
    }


    public function update(Request $request, $id)
        {
            $replacement = ReplacementModel::find($id);

            if (!$replacement) {
                return response()->json(['message' => 'Replacement not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'new_vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
                'permanent_id' => 'nullable|exists:vehicle_permanently_requests,vehicle_request_permanent_id',
                'register_by' => 'nullable|exists:users,id',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $replacement->update($request->only(['new_vehicle_id', 'permanent_id', 'register_by', 'status']));

            return response()->json($replacement);
        }


    public function destroy($id)
        {
            $replacement = ReplacementModel::find($id);

            if (!$replacement) {
                return response()->json(['message' => 'Replacement not found'], 404);
            }

            $replacement->delete();

            return response()->json(['message' => 'Replacement deleted successfully']);
        }
}
