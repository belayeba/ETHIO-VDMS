<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle\AttendanceModel;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = AttendanceModel::with(['vehicle', 'route', 'registeredBy'])->latest()->get();
        return response()->json($attendances);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'route_id' => 'required|exists:routes,route_id',
            'morning' => 'required|boolean',
            'afternoon' => 'required|boolean',
            'notes' => 'nullable|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $attendance = AttendanceModel::create([
            'vehicle_id' => $request->vehicle_id,
            'route_id' => $request->route_id,
            'register_by' => Auth::id(),
            'morning' => $request->morning,
            'afternoon' => $request->afternoon,
            'notes' => $request->notes,
        ]);

        return response()->json($attendance, 201);
    }
    public function show($id)
    {
        $attendance = AttendanceModel::with(['vehicle', 'route', 'registeredBy'])->find($id);

        if (!$attendance) {
            return redirect()->back()->with('error_message',
                    "Attendance Not found",
            );
        }

        return response()->json($attendance);
    }

    public function update(Request $request, $id)
    {
        $attendance = AttendanceModel::find($id);

        if (!$attendance) {
            return redirect()->back()->with('error_message',
                    "Attendance Not found",
            );
        }

        $validator = Validator::make($request->all(), [
            'morning' => 'nullable|boolean',
            'afternoon' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
                return redirect()->back()->with('error_message',
                "Please check your information",
          );
        }

        $attendance->update($request->only(['morning', 'afternoon', 'notes']));

        return response()->json($attendance);
    }

    public function destroy($id)
    {
        $attendance = AttendanceModel::find($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }
        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted successfully']);
    }
}
