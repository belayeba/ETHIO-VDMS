<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle\AttendanceModel;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteManagement\Route;
use App\Models\Vehicle\VehiclesModel;

class AttendanceController extends Controller
{
    public function index()

    {
        $routes = Route::get();
        $vehicles = VehiclesModel::all();

        return view('Vehicle.Attendance',compact('routes','vehicles'));
    }

    public function FetchAttendance(){


        $data = AttendanceModel::with(['vehicle', 'route', 'registeredBy'])->latest()->get();
                
                return datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('vehicle', function ($row) {
                    return $row->vehicle->plate_number;
                })

                ->addColumn('route', function ($row) {
                    return $row->route->route_name;
                })

                ->addColumn('date', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })

                ->addColumn('registeredBy', function ($row) {
                    return $row->registeredBy ? $row->registeredBy->first_name : null;
                })
                
                ->addColumn('actions', function ($row) {
                    $actions = '';                    
                    if ($row->dir_approved_by == null && $row->director_reject_reason == null) {
                        $actions .= '<button  class="btn btn-info rounded-pill view-btn"  data-vehicle="' . $row->vehicle->plate_number . '" data-route="' . $row->route->route_name . '" data-morning="' . $row->morning . '" data-afternoon="' . $row->afternoon . '" data-notes="' . $row->notes . '" title="edit"><i class="ri-eye-line"></i></button>';
                        $actions .= '<button class="btn btn-secondary rounded-pill update-btn"  data-id="' . $row->attendance_id . '" data-morning="' . $row->morning . '" data-afternoon="' . $row->afternoon . '" data-notes="' . $row->notes . '" title="edit"><i class="ri-edit-line"></i></button>';
                        $actions .= '<button class="btn btn-danger rounded-pill reject-btn" data-id="' . $row->attendance_id . '" title="edit"><i class=" ri-close-circle-fill"></i></button>';
                    }
        
                    return $actions;
                })

                ->rawColumns(['actions','vehicle','route','date','registeredBy','counter'])
                ->toJson();
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
            return redirect()->back()->with('error_message', 'Please fill the required filled!');
        }
        
        $attendance = AttendanceModel::create([
            'vehicle_id' => $request->vehicle_id,
            'route_id' => $request->route_id,
            'register_by' => Auth::id(),
            'morning' => $request->morning,
            'afternoon' => $request->afternoon,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success_message', 'Attendance Saved');
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

        return redirect()->back()->with('success_message', 'Attendance Updated!');
    }

    public function destroy(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|exists:attendances,attendance_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message', 'Something went wrong!');
        }

       
        $id = $request->input('request_id'); 
        $attendance = AttendanceModel::find($id);
        
        if (!$attendance) {
            return redirect()->back()->with('error_message', 'Attendance not found!');
        }
  
        $attendance->delete();
        return redirect()->back()->with('success_message', 'Attendance deleted successfully!');
    }
}
