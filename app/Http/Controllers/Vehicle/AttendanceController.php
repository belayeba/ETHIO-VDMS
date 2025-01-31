<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle\AttendanceModel;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteManagement\Route;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\DailyKMCalculationModel;
use App\Models\Vehicle\ReplacementModel;
use Andegna\DateTime;
use Carbon\Carbon;

class AttendanceController extends Controller
    {
        public function index()
            {

                $routes = Route::get();
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                $vehicles_in_attendance = AttendanceModel::select('vehicle_id')->where('created_at',$ethio_date)->pluck('vehicle_id')->toArray();
                // dd($ethio_date);
                //$already_registered = Route::where('created_at', $ethio_date)->pluck('vehicle_id')->toArray();
                $vehicles = VehiclesModel::select('vehicle_id','plate_number')->whereNotIn('vehicle_id',$vehicles_in_attendance)->whereIn('rental_type',['morning_afternoon_minibus','40_60'])->get();
                // $vehicles = Route::select('vehicle_id')->get();
                return view('Vehicle.Attendance',compact('routes','vehicles'));
            }
        public function ConvertToEthiopianDate($today)
            {
                $ethiopianDate = new DateTime($today);

                // Format the Ethiopian date
                $formattedDate = $ethiopianDate->format('Y-m-d');

                // Display the Ethiopian date
                return $formattedDate;
            }
        public function FetchAttendance()
            {
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                //$attend_vehicle = VehiclesModel::where('status',true)->whereIn('rental_type',['morning_afternoon_minibus','40_60'])->pluck('vehicle_id')->toArray();
                $data = AttendanceModel::with(['vehicle', 'route', 'registeredBy'])->where('created_at',$ethio_date)->get();
                //$data = AttendanceModel::whereIn('vehicle_id',$attend_vehicle)->whereNotIn('vehicle_id',$check_attendance)->get();
                //$already_registered = Route::where('created_at', $ethio_date)->pluck('vehicle_id')->toArray();
               // $data = VehiclesModel::select('vehicle_id','plate_number')->whereNotIn('vehicle_id',$vehicles_in_attendance)->whereIn('rental_type',['morning_afternoon_minibus','40_60'])->get();
                //$data = AttendanceModel::with(['vehicle', 'route', 'registeredBy'])->latest()->get();
                        
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
                    //'route_id' => 'required|exists:routes,route_id',
                    'morning' => 'required|boolean',
                    'afternoon' => 'required|boolean',
                    'notes' => 'nullable|string|max:200',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error_message', 'Please fill the required filled!');
                }
                $the_routes = Route::select('route_id')->where('vehicle_id',$request->input('vehicle_id'))->first();
                $route_id = $the_routes->route_id;
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                $check_attendance = AttendanceModel::select('morning','afternoon')->where('created_at',$ethio_date)->where('vehicle_id',$request->input('vehicle_id'))->first();
               if($check_attendance)
                    {
                        if($check_attendance->morning && $check_attendance->afternoon)
                            {
                                return redirect()->back()->with('error_message', 'Attendance already taken');
                            }
                    }
                AttendanceModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'route_id' => $route_id,
                    'register_by' => Auth::id(),
                    'morning' => $request->morning,
                    'afternoon' => $request->afternoon,
                    'created_at' => $ethio_date,
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
    
    public function ReportPage()
    {
        $vehicles = VehiclesModel::select('vehicle_id', 'plate_number','rental_type')->whereNotNull('rental_type')->get();
        $routes = Route::select('vehicle_id', 'route_name')->get();
        
        return view('vehicle.attendanceReport',compact('vehicles','routes'));

    }

    public function filterReport(Request $request)
    {
        
        // Validate input filters
        $validator = Validator::make($request->all(), [
            'vehicle_type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                    $validator->errors(),
            );
        }

        if ($request->has('export')) {
            session([
                'vehicle_type' => $request->input('plate_vehicle_typenumber'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
        }

        // Get filter parameters
        $vehicle_type = $request->input('vehicle_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

       
        // Query the daily KM data with filters
        
        if ($vehicle_type == "40/60" || $vehicle_type == "morning_afternoon_minibus" ) {
            $query = AttendanceModel::with('vehicle', 'route');
            $query->whereHas('vehicle', function ($q) use ($vehicle_type) {
                
                $q->where('rental_type', 'LIKE', "%{$vehicle_type}%");

            });

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $vehicles = $query->select('vehicle_id')->with('vehicle')
            ->with('vehicle') 
            ->groupBy('vehicle_id')
            ->selectRaw("
                    vehicle_id,
                    SUM(
                        CASE 
                            WHEN morning = 1 AND afternoon = 1 THEN 1
                            WHEN morning = 1 OR afternoon = 1 THEN 0.5
                            ELSE 0
                        END
                    ) as registration_count
                ")
            ->get();

        }

        elseif ($vehicle_type == "whole_day") {
            $query = DailyKMCalculationModel::with('vehicle');
            $query->whereHas('vehicle', function ($q) use ($vehicle_type) {
                
                $q->where('rental_type', 'LIKE', "%{$vehicle_type}%");

            });

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $vehicles = $query->select('vehicle_id')->with('vehicle')
            ->with('vehicle') 
            ->groupBy('vehicle_id')
            ->selectRaw("
                    vehicle_id,
                    SUM(
                        CASE 
                        WHEN morning_km IS NOT NULL AND afternoon_km IS NOT NULL THEN 1
                        WHEN (morning_km IS NOT NULL OR afternoon_km IS NOT NULL) THEN 0.5
                        ELSE 0
                    END
                    ) as registration_count
                ")
            ->get();
           
        }

        if ($vehicle_type == "position") {
          
            // $query = VehiclePermanentlyRequestModel::with('vehicle');
            // $query->whereHas('vehicle', function ($q) use ($vehicle_type) {
                
            //     $q->where('rental_type', 'LIKE', "%{$vehicle_type}%");

            // });

            $query = VehiclePermanentlyRequestModel::with('vehicle');
            $query->whereHas('vehicle', function ($q) {
                $q->whereNotNull('vehicle_id'); 
            });

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
 
            $vehicles = $query->get()->map(function ($request) use ($startDate, $endDate) 
            {
                $replacement = ReplacementModel::where('permanent_id', $request->vehicle_request_permanent_id)->first();

                // Parse dates
                $startDateObj = \Carbon\Carbon::parse($startDate);
                $endDateObj = $endDate ? \Carbon\Carbon::parse($endDate) : \Carbon\Carbon::now();
                // dd( $endDateObj);

                if ($replacement) {
                    // Calculate service durations
                    $oldVehicleServiceDays = $replacement->created_at
                        ? \Carbon\Carbon::parse($replacement->created_at)->diffInDays($startDateObj)
                        : null;

                    $newVehicleServiceDays = $endDateObj->diffInDays(\Carbon\Carbon::parse($replacement->created_at));

                    return (object)[
                        'date' => $request->created_at->format('Y-m-d'),
                        'old_vehicle' => $request->vehicle->plate_number ?? 'N/A',
                        'old_vehicle_service_days' => $oldVehicleServiceDays,
                        'new_vehicle' => $replacement->newVehicle->plate_number ?? 'N/A',
                        'new_vehicle_service_days' => $newVehicleServiceDays,
                    ];
                }

                // If no replacement, return the original vehicle data
                return (object)[
                    'date' => $request->created_at->format('Y-m-d'),
                    'plate_number' => $request->vehicle->plate_number ?? 'N/A',
                    'service_days' => $startDateObj->diffInDays($endDateObj),
                ];
            });
         dd($vehicles);
        }
        
            $vehicles = $vehicles->map(function ($q) use ($request) {
            $startDate = \Carbon\Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->input('end_date'))->startOfDay();
                                    
            return (object) [
                // 'date' => $q->created_at->format('Y-m-d'),
                'plate_number' => $q->vehicle->plate_number ?? 'N?A',
                'rental_type' => $q->vehicle->rental_type,
                'vehicle_id' => $q->vehicle->vehicle_id,
                'interval' => $request->input('start_date') .' / '. $request->input('end_date') ?? 'N/A',
                'total' => $q->registration_count, 
            ];
        });

        if ($vehicles->isEmpty()) {
            $vehicles = $query;
        }

        $routes = Route::select('vehicle_id', 'route_name')->get();

        if ($request->input('export') == 1) {
            return Excel::download(new FilteredReportExport($vehicles), 'filtered_report.xlsx');
        }

        return view('vehicle.attendanceReport', compact( 'vehicles','routes'));
    }

}
