<?php

namespace App\Http\Controllers\Vehicle;

use App\Exports\FilteredReportExport;
use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use App\Models\Organization\ClustersModel;
use App\Models\Organization\DepartmentsModel;
use App\Models\User;
use App\Models\Vehicle\DailyKMCalculationModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Andegna\DateTime;

class Daily_KM_Calculation extends Controller
    {
        public function ConvertToEthiopianDate($today)
            {
                $ethiopianDate = new DateTime($today);
                // Format the Ethiopian date
                $formattedDate = $ethiopianDate->format('Y-m-d');
                // Display the Ethiopian date
                return $formattedDate;
            }
        public function displayPage()
            {
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                $vehicle = VehiclesModel::whereIn('rental_type',['whole_day','field','service'])->whereNot('status',false)->get();
                $TodaysDate = DailyKMCalculationModel::where('created_at',$ethio_date)->latest()->get();
                return view('Vehicle.DailKmForm',compact('vehicle','TodaysDate'));
            }
           
            public function ReportPage()
            {
                $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                $drivers = DriversModel::with('registeredBy', 'user')->get();
                $departments = DepartmentsModel::select('department_id', 'name')->get();
        
                // dd($drivers->driver_id);
                // Fetch the daily KM data
                $dailkms = DailyKMCalculationModel::with('vehicle', 'driver')
                    ->latest()
                    ->take(50)
                    ->oldest()
                    ->get();
        
                    $dailkms = $dailkms->map(function ($km) {
                        return (object) [
                            'date' => $km->created_at->format('Y-m-d'),
                            'plate_number' => $km->vehicle->plate_number ?? 'N?A',
                            'morning_km' => $km->morning_km ?? 'N/A',
                            'afternoon_km' => $km->afternoon_km,
                            // 'daily_km' => 342,
                            // 'night_km' => 400,
                            'daily_km' => $km->getDailyKmAttribute($km->vehicle->vehicle_id),
                            'night_km' => $km->getNightKmAttribute($km->vehicle->vehicle_id),
                        ];
                    });
        
        
                return view('Vehicle.dailyReport', compact('vehicles', 'drivers', 'departments', 'dailkms'));
            }

            public function vehicleReport()
        {
        $drivers = User::all();
        $departments = DepartmentsModel::select('department_id', 'name')->get();
        $clusters = ClustersModel::select('cluster_id', 'name')->get();

        $vehicles = VehiclesModel::with('maintenances', 'requestedBy','fuelings','driver','inspection')
            ->latest()
            ->take(50)
            ->get();
        
        $vehicles = $vehicles->map(function ($vehicle) {
            return (object) [
                'plate_number' => $vehicle->plate_number ?? 'N/A',
                'vin' => $vehicle->vin,
                'driver' => is_null($vehicle->driver) ? 'N/A' : $vehicle->driver->users->username ?? 'N/A',
                'vehicle_type' => $vehicle->vehicle_type,
                'vehicle_category' => $vehicle->vehicle_category,
                'rental_type' => $vehicle->rental_type,
                'requested_by' => is_null($vehicle->requestedBy) ? 'N/A' : $vehicle->requestedBy->username,
                'fuel_amount' => $vehicle->fuel_amount,
                'mileage' => $vehicle->mileage,
                'last_service' => $vehicle->last_service,
                'next_service' => $vehicle->next_service,
                'status' => $vehicle->status == 1 ? 'Active' : 'Inactive',
            ];
        });

        //dd($vehicles);

        return view('Vehicle.vehicleReport', compact('vehicles', 'drivers', 'departments', 'clusters', 'vehicles'));
        }

        public function filterVehicleReport(Request $request)
        {
            // dd($request);
            $validator = Validator::make($request->all(), [
                'plate_number' => 'nullable|string',
                'name' => 'nullable|string',
                'vehicle_type' => 'nullable|string',
                'vehicle_category' => 'nullable|string',
                'rental_type' => 'nullable|string',
                'status' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // Get filter parameters
            if ($request->has('export')) {
                session([
                    'plate_number' => $request->input('plate_number'),
                    'driver_name' => $request->input('driver_name'),
                    'vehicle_type' => $request->input('vehicle_type'),
                    'vehicle_category' => $request->input('vehicle_category'),
                    'rental_type' => $request->input('rental_type'),
                    'status' => $request->input('status'),
                    'date_range' => $request->input('date_range'),
                ]);
            }
    
            // Retrieve filters from session
            $plateNumber = session('plate_number');
            $driverName = session('driver_name');
            $vehicleType = session('vehicle_type');
            $rentalType = session('rental_type');
            $vehicleCategory = session('vehicle_category');
            $status = session('status');
            $dateRange = session('date_range');
    
            $dates = explode(' - ', $dateRange);
            // Query the daily KM data with filters
            $query = VehiclesModel::with('maintenances', 'requestedBy','fuelings','driver','inspection');
    
            if ($plateNumber) {
                $query->whereHas('vehicle', function ($q) use ($plateNumber) {
                    $q->where('plate_number', 'LIKE', "%{$plateNumber}%");
                });
    
            }
            elseif ($vehicleType) {
                $query->where('vehicle_type', 'LIKE', "%{$vehicleType}%");
            } elseif ($vehicleCategory) {
                $query->where('vehicle_category', 'LIKE', "%{$vehicleCategory}%");
            } elseif ($rentalType) {
                $query->where('rental_type', 'LIKE', "%{$rentalType}%");
            } elseif ($status) {
                $status = $status == "Active" ? 1 : 0;
                $query->where('status', 'LIKE', "%{$status}%");
            }
            elseif ($driverName) {
                $query->where('username', 'LIKE', "%{$driverName}%");
            }
    
            $vehicles = $query->get();
    
            //dd($vehicle);
    
            $vehicles = $vehicles->map(function ($vehicle) {
                return (object) [
                    'plate_number' => $vehicle->plate_number ?? 'N/A',
                    'vin' => $vehicle->vin,
                    'driver' => is_null($vehicle->driver) ? 'N/A' : $vehicle->driver->users->username ?? 'N/A',
                    'vehicle_type' => $vehicle->vehicle_type,
                    'vehicle_category' => $vehicle->vehicle_category,
                    'rental_type' => $vehicle->rental_type,
                    'requested_by' => is_null($vehicle->requestedBy) ? 'N/A' : $vehicle->requestedBy->username,
                    'fuel_amount' => $vehicle->fuel_amount,
                    'mileage' => $vehicle->mileage,
                    'last_service' => $vehicle->last_service,
                    'next_service' => $vehicle->next_service,
                    'status' => $vehicle->status == 1 ? 'Active' : 'Inactive',
                ];
            });
    
            if ($vehicles->isEmpty()) {
                $vehicles = $query;
            }
    
            if ($request->input('export') == 1) {
                return Excel::download(new FilteredReportExport($vehicles), 'filtered_report.xlsx');
            }
    
            $drivers = User::all();
            
            return view('Vehicle.vehicleReport', compact('vehicles', 'drivers'));
    
        }
        
            public function permanentReport()
            {
                $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                $drivers = User::all();
                $departments = DepartmentsModel::select('department_id', 'name')->get();
                $clusters = ClustersModel::select('cluster_id', 'name')->get();
        
                // dd($drivers->driver_id);
                // Fetch the daily KM data
                $dailkms = VehiclePermanentlyRequestModel::with('vehicle', 'requestedBy')
                    ->where('status', 1)
                    ->oldest()
                    ->take(50)
                    ->get();
                $dailkms = $dailkms->map(function ($km) {
                    return (object) [
                        'given_date' => $km->given_date,
                        'requested_by' => $km->requestedBy->first_name .' '.$km->requestedBy->last_name,
                        'plate_number' => $km->vehicle->plate_number ?? 'N/A',
                        'purpose' => $km->purpose,
                        'mileage' => $km->mileage,
                        'department_name' => $km->requestedBy->department->name ?? 'N/A',
                        'cluster_name' => $km->requestedBy->department->cluster->name ?? 'N/A',
        
                    ];
                });
        
                return view('Vehicle.permanentReport', compact('vehicles', 'drivers', 'departments', 'clusters', 'dailkms'));
            }
        
            public function temporaryReport()
            {
                $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                $drivers = User::all();
                $departments = DepartmentsModel::select('department_id', 'name')->get();
                $clusters = ClustersModel::select('cluster_id', 'name')->get();
        
                // dd($drivers->driver_id);
                // Fetch the daily KM data
                $dailkms = VehicleTemporaryRequestModel::with('vehicle', 'driver', 'requestedBy')
                    ->where('status', 'Approved')    
                    ->latest()
                    ->take(50)
                    ->get();
        // dd($dailkms);
        
                    $dailkms = $dailkms->map(function ($km) {
                        return (object) [
                            'requested_by' => $km->requestedBy->username,
                            'vehicle_type' => $km->vehicle_type,
                            'plate_number' => $km->vehicle->plate_number ?? 'N/A',
                            'purpose' => $km->purpose,
                            'start_date' => $km->start_date,
                            'start_time' => $km->start_time,
                            'end_date' => $km->end_date,
                            'end_time' => $km->end_time,
                            'in_out_of_addis_ababa' => $km->in_out_town == '1' ? "IN" : "OUT",
                            'how_many_days' => $km->how_many_days,
                            'start_km' => $km->start_km,
                            'end_km' => $km->end_km,
                            'with_driver' => $km->with_driver == 1 ? "With" : "Without",
                            'start_location' => $km->start_location,
                            'end_locations' => $km->end_locations,
                            'department_name' => $km->requestedBy->department->name ?? 'N/A',
                            'cluster_name' => $km->requestedBy->department->cluster->name ?? 'N/A',
            
                        ];
                    });
        
        
                return view('Vehicle.temporaryReport', compact('vehicles', 'drivers', 'departments', 'clusters', 'dailkms'));
            }
        
            public function filterReport(Request $request)
            {
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
                        'daily_km' => $km->getDailyKmAttribute($km->vehicle->vehicle_id),
                        'night_km' => $km->getNightKmAttribute($km->vehicle->vehicle_id),
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
        
            public function filterPermanentReport(Request $request)
            {
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
                // Get filter parameters
                if ($request->has('export')) {
                    session([
                        'plate_number' => $request->input('plate_number'),
                        'driver_name' => $request->input('driver_name'),
                        'department' => $request->input('department'),
                        'cluster' => $request->input('cluster'),
                        'date_range' => $request->input('date_range'),
                    ]);
                }
        
                // Retrieve filters from session
                $plateNumber = session('plate_number');
                $driverName = session('driver_name');
                $department = session('department');
                $cluster = session('cluster');

                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                // Query the daily KM data with filters
                $query = VehiclePermanentlyRequestModel::with('vehicle', 'requestedBy')
                    ->where('status', 1);
        
                if ($plateNumber) {
                    $query->whereHas('vehicle', function ($q) use ($plateNumber) {
                        $q->where('plate_number', 'LIKE', "%{$plateNumber}%");
                    });
        
                } elseif ($startDate && $endDate) {
                    $query->whereBetween('given_date', [$startDate, $endDate]);
                }
                // return response()->json([
                //     // 'vehicles' => $vehicles,
                //     // 'drivers' => $drivers,
                //     // 'departments' => $departments,
                //     'dailkms' => $dailkms
                //  ]);
        
                elseif ($department) {
                    $query->whereHas('requestedBy.department', function ($q) use ($department) {
                        $q->where('department_id', 'LIKE', "%{$department}%");
                    });
                } elseif ($cluster) {
        
                    $query->whereHas('requestedBy.department.cluster', function ($q) use ($cluster) {
                        $q->where('cluster_id', 'LIKE', "%{$cluster}%");
                    });
                } elseif ($driverName) {
                    $query->whereHas('requestedBy', function ($q) use ($driverName) {
                        $q->where('username', 'LIKE', "%{$driverName}%");
                    });
                }
        
                $dailkms = $query->oldest()->get();
        
                $dailkms = $dailkms->map(function ($km) {
                    return (object) [
                        'given_date' => $km->given_date,
                        'requested_by' => $km->requestedBy->first_name .' '.$km->requestedBy->last_name,
                        'plate_number' => $km->vehicle->plate_number ?? 'N/A',
                        'purpose' => $km->purpose,
                        'mileage' => $km->mileage,
                        'department_name' => $km->requestedBy->department->name ?? 'N/A',
                        'cluster_name' => $km->requestedBy->department->cluster->name ?? 'N/A',
                    ];
                });
        
                if ($dailkms->isEmpty()) {
                    $dailkms = $query;
                }
        
                if ($request->input('export') == 1) {
                    return Excel::download(new FilteredReportExport($dailkms), 'filtered_report.xlsx');
                }
        
                $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                $drivers = User::all();
                $departments = DepartmentsModel::select('department_id', 'name')->get();
                $clusters = ClustersModel::select('cluster_id', 'name')->get();
        
                return view('Vehicle.permanentReport', compact('vehicles', 'drivers', 'departments', 'clusters', 'dailkms'));
        
            }
        public function filterTemporaryReport(Request $request)
            {
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
                // Get filter parameters
                if ($request->has('export')) {
                    session([
                        'plate_number' => $request->input('plate_number'),
                        'driver_name' => $request->input('driver_name'),
                        'department' => $request->input('department'),
                        'cluster' => $request->input('cluster'),
                        'date_range' => $request->input('date_range'),
        
                    ]);
                }
        
                // Retrieve filters from session
                $plateNumber = session('plate_number');
                $driverName = session('driver_name');
                $department = session('department');
                $cluster = session('cluster');

                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                // Query the daily KM data with filters
                $query = VehicleTemporaryRequestModel::with('vehicle', 'requestedBy')
                    ->where('status', 'Approved');
        
                    if ($plateNumber) {
                        $query->whereHas('vehicle', function ($q) use ($plateNumber) {
                            $q->where('plate_number', 'LIKE', "%{$plateNumber}%");
                        });
            
                    }elseif ($driverName) {
                        $query->whereHas('requestedBy', function ($q) use ($driverName) {
                            $q->where('username', 'LIKE', "%{$driverName}%");
                        });
        
                    }elseif ($startDate && $endDate) {
                        $query->whereBetween('start_date', [$startDate, $endDate]);
                    }
                    
            
                    // return response()->json([
                    //     // 'vehicles' => $vehicles,
                    //     // 'drivers' => $drivers,
                    //     // 'departments' => $departments,
                    //     'dailkms' => $dailkms
                    //  ]);
            
                    elseif ($department) {
                        $query->whereHas('requestedBy.department', function ($q) use ($department) {
                            $q->where('department_id', 'LIKE', "%{$department}%");
                        });
                    } elseif ($cluster) {
            
                        $query->whereHas('requestedBy.department.cluster', function ($q) use ($cluster) {
                            $q->where('cluster_id', 'LIKE', "%{$cluster}%");
                        });
                    } elseif ($driverName) {
                        $query->whereHas('requestedBy', function ($q) use ($driverName) {
                            $q->where('username', 'LIKE', "%{$driverName}%");
                        });
                    }
            
                    $dailkms = $query->get();
            
                    $dailkms = $dailkms->map(function ($km) {
                        return (object) [
                            'requested_by' => $km->requestedBy->username,
                            'vehicle_type' => $km->vehicle_type,
                            'plate_number' => $km->vehicle->plate_number ?? 'N/A',
                            'purpose' => $km->purpose,
                            'start_date' => $km->start_date,
                            'start_time' => $km->start_time,
                            'end_date' => $km->end_date,
                            'end_time' => $km->end_time,
                            'in_out_of_addis_ababa' => $km->in_out_town == '1' ? "IN" : "OUT",
                            'how_many_days' => $km->how_many_days,
                            'start_km' => $km->start_km,
                            'end_km' => $km->end_km,
                            'with_driver' => $km->with_driver == 1 ? "With" : "Without",
                            'start_location' => $km->start_location,
                            'end_locations' => $km->end_locations,
                            'department_name' => $km->requestedBy->department->name ?? 'N/A',
                            'cluster_name' => $km->requestedBy->department->cluster->name ?? 'N/A',
            
                        ];
                    });
            
                    if ($dailkms->isEmpty()) {
                        $dailkms = $query;
                    }
            
                    if ($request->input('export') == 1) {
                        return Excel::download(new FilteredReportExport($dailkms), 'filtered_report.xlsx');
                    }
            
                    $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                    $drivers = User::all();
                    $departments = DepartmentsModel::select('department_id', 'name')->get();
                    $clusters = ClustersModel::select('cluster_id', 'name')->get();
        
                return view('Vehicle.temporaryReport', compact('vehicles', 'drivers', 'departments', 'clusters', 'dailkms'));
        
            }
           //getting today's info
        public function displayForm()
            {
                    $today = Carbon::now();
                    $ethio_date = $this->ConvertToEthiopianDate($today);
                    $TodaysDate = DailyKMCalculationModel::where('created_at',$ethio_date)->latest()->get();
                    return view('DailKmForm',compact('TodaysDate'));
            }
        public function morning_km(Request $request)
            {
                    // Validate the request
                    $validator = Validator::make($request->all(), [
                        'morning_km' => 'required|integer',
                        'vehicle'=>'required|uuid|exists:vehicles,vehicle_id',
                        //'driver_id'=>'required|uuid|exists:drivers,driver_id'
                    ]);            
                    // If validation fails, return an error response
                    if ($validator->fails()) 
                        {
                            return redirect()->back()->with('error_message',
                                 $validator->errors(),
                            );
                        }
                    $today = Carbon::now();
                    $ethio_date = $this->ConvertToEthiopianDate($today);
                    $id = Auth::id();
                    try
                        {
                            $vehicle_daily = DailyKMCalculationModel::where('vehicle_id',$request->vehicle)->whereDate('created_at',$ethio_date)->first();
                            //dd($vehicle);
                            $driver_from_vehicle = VehiclesModel::select('driver_id')->where('vehicle_id',$request->vehicle)->first();
                           /// $driver_id = $vehicle->driver_id;
                           $driver_id = $driver_from_vehicle->driver_id;
                            if($vehicle_daily)
                              {
                                   // update morning km
                                   $vehicle_daily->morning_km = $request->morning_km;
                                   $vehicle_daily->save();
                                    // Success: Record was created
                                    return redirect()->back()->with('success_message',
                                    "Morning KM calcuation Updated Successfully.",
                                 );
                              }
                            // Create Daily Km calculation
                            DailyKMCalculationModel::create([
                                'register_by'=>$id,
                                'driver_id'=>$driver_id,
                                'vehicle_id' => $request->vehicle,
                                'morning_km' => $request->morning_km,
                                'created_at' => $ethio_date,
                                ]);
                                // Success: Record was created
                                return redirect()->back()->with('success_message',
                                'Morning KM calcuation Registered Successfully.',
                            );
                           
                                
                        }
                    catch (Exception $e) 
                        {
                            // Handle the case when the vehicle request is not found
                            return redirect()->back()->with('error_message',
                            'Sorry, Something went wrong',
                        );
                    }
            }
        public function aftern_km(Request $request)
            {
                    // Validate the request
                    $validator = Validator::make($request->all(), [
                        'afternoon_km' => 'required|integer',
                        'vehicle'=>'required|uuid|exists:vehicles,vehicle_id',
                        // 'driver_id'=>'required|uuid|exists:drivers,driver_id'
                    ]);            
                    // If validation fails, return an error response
                    if ($validator->fails()) 
                        {
                            return redirect()->back()->with('error_message',
                                 $validator->errors(),
                            );
                        }
                    $today = Carbon::now();
                    $ethio_date = $this->ConvertToEthiopianDate($today);

                    $id = Auth::id();
                    try
                        {
                            $vehicle = DailyKMCalculationModel::where('vehicle_id',$request->vehicle)->whereDate('created_at',$ethio_date)->first();
                            $driver_from_vehicle = VehiclesModel::select('driver_id')->where('vehicle_id',$request->vehicle)->first();
                            /// $driver_id = $vehicle->driver_id;
                            $driver_id = $driver_from_vehicle->driver_id;
                            if($vehicle)
                              {
                                   // update morning km
                                   $vehicle->afternoon_km = $request->afternoon_km;
                                   $vehicle->save();
                                    // Success: Record was created
                                    return redirect()->back()->with('success_message',
                                            'Afternoon KM calcuation Registered Successfully.',
                                    );
                              }
                            // Create Daily Km calculation
                            DailyKMCalculationModel::create([
                                'register_by'=>$id,
                                'driver_id'=>$driver_id,
                                'vehicle_id' => $request->vehicle,
                                'afternoon_km' => $request->afternoon_km,
                                'created_at' => $ethio_date,
                             ]);
                            // Success: Record was created
                            return redirect()->back()->with('success_message',
                            'Afternoon KM calcuation Registered Successfully.',
                       );
                                
                        }
                    catch (Exception $e) 
                        {
                            // Handle the case when the vehicle request is not found
                            return redirect()->back()->with('error_message',
                            'Sorry, Something went wrong',
                       );
                        }
            }
        public function get_vehicle_daily_km(Request $request)
            {
                    $validator = Validator::make($request->all(), [
                        'vehicle_id'=>'required|uuid|vehicles_id',
                    ]);
                    // If validation fails, return an error response
                    if ($validator->fails()) 
                        {
                           return redirect()->back()->with('error_message',
                                 "Warning You are denied the service",
                            );
                        }
                    $id = $request->input('vehicle_id');
                    $today = Carbon::now();
                    $ethio_date = $this->ConvertToEthiopianDate($today);
                    $vehicle = DailyKMCalculationModel::where('created_at',$ethio_date)->where('vehicle_id',$id)->first();
                    
                    return response()->json([
                        'success_message' => false,
                        'vehicle' => $vehicle,
                    ]);
            }
         public function CheckVehicle(Request $request)
            {
               try {
                //code...
                $id = $request->input('id');
                $today = Carbon::now();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                // dd($ethio_date);
                $vehicle = DailyKMCalculationModel::where('created_at', $ethio_date)->where('vehicle_id',$id)->first();
                // dd($vehicle);
                if($vehicle->morning_km !== null){
                    return response()->json([
                        'success' => true,
                        'message' => "Morning km is filled",
                        'filledField' => 'morning',
                    ]);
                }
                elseif ($vehicle->afternoon_km !== null) {
                    # code...
                    return response()->json([
                        'success' => true,
                        'message' => "Afternoon km is filled",
                        'filledField' => 'evening',
                    ]);
                }
                else {
                    # code...
                    return response()->json([
                        'success_message' => true,
                        'message' => "Both filled",
                    ]);
                }
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json([
                        'success_message' => true,
                        'message' => "Choose to fill",
                    ]);
                }
            }
    }
