<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle\AttendanceModel;
use Illuminate\Support\Facades\Auth;
use App\Models\RouteManagement\Route;
use App\Models\Vehicle\VehiclesModel;
use Andegna\DateTime;
use Carbon\Carbon;

class AttendanceController extends Controller
    {
        public function index()
            {
                $routes = Route::get();
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                $vehicles_in_attendance = AttendanceModel::select('vehicle_id')->where('created_at',$ethio_date)->get();
                $vehicles = Route::select('vehicle_id')
                                ->whereNotIn('vehicle_id', function ($query) use ($ethio_date) {
                                    $query->select('vehicle_id')
                                        ->from('attendances')
                                        ->where('created_at', $ethio_date);
                                })
                                ->get();
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
        
        return view('vehicle.attendanceReport');

    }

    public function filterReport(Request $request)
    {
        dd($request);
        // Validate input filters
        $validator = Validator::make($request->all(), [
            'plate_number' => 'nullable|string',
            'name' => 'nullable|string',
            'department' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                         $validator->errors(),
                    );
        }
// dd('hello');
        if ($request->has('export')) {
            session([
                'plate_number' => $request->input('plate_number'),
                'name' => $request->input('name'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
        }
        // Get filter parameters
        $plateNumber = $request->input('plate_number');
        $name = $request->input('name');
        $department = $request->input('department');
        $cluster = $request->input('cluster');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filter = $request->input('filter');

       
        // Query the daily KM data with filters
        $query = DailyKMCalculationModel::with('vehicle', 'driver');
        if ($plateNumber) {
            $query->whereHas('vehicle', function ($q) use ($plateNumber) {
                $q->where('plate_number', 'LIKE', "%{$plateNumber}%");
            });

        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        

        

        $dailkms = $query->oldest()->get();

        $dailkms = $dailkms->map(function ($km) {
            return (object) [
                'date' => $km->created_at->format('Y-m-d'),
                'plate_number' => $km->vehicle->plate_number ?? 'N?A',
                'morning_km' => $km->morning_km ?? 'N/A',
                'afternoon_km' => $km->afternoon_km,
                'daily_km' => $km->afternoon_km - $km->morning_km,
                'night_km' => $km->night_km,
            ];
        });

        if ($dailkms->isEmpty()) {
            $dailkms = $query;
        }

        $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
        $drivers = DriversModel::with('user')->get();
        $departments = DepartmentsModel::select('department_id', 'name')->get();
        $clusters = ClustersModel::select('cluster_id', 'name')->get();
        // return response()->json([
        //     // 'vehicles' => $vehicles,
        //     // 'drivers' => $drivers,
        //     // 'departments' => $departments,
        //     'dailkms' => $dailkms
        //  ]);

        if ($request->input('export') == 1) {
            return Excel::download(new FilteredReportExport($dailkms), 'filtered_report.xlsx');
        }

        return view('Vehicle.dailyReport', compact('vehicles', 'drivers', 'departments', 'dailkms'));
    }

}
