<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\DailyKMCalculationModel;
use Illuminate\Http\Request;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Organization\DepartmentsModel;
use App\Models\Driver\DriversModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Daily_KM_Calculation extends Controller
    {
        public function displayPage()
            {
                $today = Carbon::today()->toDateString();
                $vehicle = VehiclesModel::get();
                $TodaysDate = DailyKMCalculationModel::where('date',$today)->latest()->get();
                return view('Vehicle.DailKmForm',compact('vehicle','TodaysDate'));
            }
        public function ReportPage()
            {
                $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                $drivers = DriversModel::with('driver_id', 'users')->get();
                $departments = DepartmentsModel::select('department_id', 'name')->get(); 
        
                // dd($drivers->driver_id);
                // Fetch the daily KM data
                $dailkms = DailyKMCalculationModel::with('vehicle', 'driver', 'registeredBy')
                                ->latest()
                                ->take(50)
                                ->get();
            
                return view('Vehicle.dailyReport', compact('vehicles', 'drivers', 'departments', 'dailkms'));
            }

            public function filterReport(Request $request)
            {
                // Validate input filters
                $validator = Validator::make($request->all(), [
                    'plate_number' => 'nullable|string',
                    'name' => 'nullable|string',
                    'department' => 'nullable|string',
                    'start_date' => 'nullable|date',
                    'end_date' => 'nullable|date',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Get filter parameters
                $plateNumber = $request->input('plate_number');
                $name = $request->input('name');
                $department = $request->input('department');
                $dateRange = $request->input('date_range');

                $dates = explode(' - ', $dateRange);
                $startDate = $dates[0];
                $endDate = $dates[1];

                // Query the daily KM data with filters
                $query = DailyKMCalculationModel::with('vehicle', 'driver');

                if ($plateNumber) {
                    $query->whereHas('vehicle', function ($q) use ($plateNumber) {
                        $q->where('plate_number', 'LIKE', "%{$plateNumber}%");
                    });

                }

                if ($name) {
                    $query->whereHas('driver', function ($q) use ($name) {
                        $q->where('name', 'LIKE', "%{$name}%");
                    });
                }

                if ($department) {
                    $query->whereHas('driver', function ($q) use ($department) {
                        $q->where('department', 'LIKE', "%{$department}%");
                    });
                }

                if ($startDate && $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate]);

                }



                $dailkms = $query->latest()->get();

                if($dailkms->isEmpty()) {
                    $dailkms = $query;
                }

                $vehicles = VehiclesModel::select('vehicle_id', 'plate_number')->get();
                $drivers = DriversModel::with('driver_id')->get();
                $departments = DepartmentsModel::select('department_id', 'name')->get(); 
            
            
                return view('Vehicle.dailyReport', compact('vehicles', 'drivers', 'departments', 'dailkms'));
            }


        //getting today's info
        public function displayForm()
            {
                    $today = Carbon::today()->toDateString();
                    $TodaysDate = DailyKMCalculationModel::where('date',$today)->latest()->get();
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
                            return response()->json([
                                'success' => false,
                                'message' => $validator->errors(),
                            ]);
                        }
                    $today = Carbon::today()->toDateString();
                    $id = Auth::id();
                    try
                        {
                            $vehicle_daily = DailyKMCalculationModel::where('vehicle_id',$request->vehicle)->whereDate('created_at',$today)->first();
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
                                    return response()->json([
                                        'success' => true,
                                        'message' => 'Morning KM calcuation Registered Successfully.',
                                    ]);
                              }
                            // Create Daily Km calculation
                            DailyKMCalculationModel::create([
                                'register_by'=>$id,
                                'driver_id'=>$driver_id,
                                'vehicle_id' => $request->vehicle,
                                'morning_km' => $request->morning_km,
                                'date' => $today,
                            ]);
                            // Success: Record was created
                            return response()->json([
                                'success' => true,
                                'message' => 'Morning KM calcuation Registered Successfully.',
                            ]);
                                
                        }
                    catch (Exception $e) 
                        {
                            // Handle the case when the vehicle request is not found
                            return response()->json([
                                'success' => false,
                                'message' => $e,
                            ]);
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
                            return response()->json([
                                'success' => false,
                                'message' => $validator->errors(),
                            ]);
                        }
                    $today = Carbon::today()->toDateString();
                    $id = Auth::id();
                    try
                        {
                            $vehicle = DailyKMCalculationModel::where('vehicle_id',$request->vehicle)->whereDate('created_at',$today)->first();
                            if($vehicle)
                              {
                                   // update morning km
                                   $vehicle->afternoon_km = $request->afternoon_km;
                                   $vehicle->save();
                                    // Success: Record was created
                                    return response()->json([
                                        'success' => true,
                                        'message' => 'Morning KM calcuation Registered Successfully.',
                                    ]);
                              }
                            // Create Daily Km calculation
                            DailyKMCalculationModel::create([
                                'created_by'=>$id,
                                'driver_id'=>$request->driver_id,
                                'vehicle_id' => $request->vehicle,
                                'afternoon_km' => $request->afternoon_km,
                                'date' => $today,
                             ]);
                            // Success: Record was created
                            return response()->json([
                                'success' => true,
                                'message' => 'Afternoon KM calcuation Registered Successfully.',
                            ]);
                                
                        }
                    catch (Exception $e) 
                        {
                            // Handle the case when the vehicle request is not found
                            return response()->json([
                                'success' => false,
                                'message' => 'Sorry, Something went wrong',
                            ]);
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
                            return response()->json([
                                'success' => false,
                                'message' => "Warning You are denied the service",
                            ]);
                        }
                    $id = $request->input('vehicle_id');
                    $today = Carbon::today()->toDateString();
                    $vehicle = DailyKMCalculationModel::where('date',$today)->where('vehicle_id',$id)->first();
                    return response()->json([
                        'success' => false,
                        'vehicle' => $vehicle,
                    ]);
            }
        public function delete_morningkm(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'vehicle_id'=>'required|uuid|vehicles_id',
                ]);
                // If validation fails, return an error response
                if ($validator->fails()) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => "Warning You are denied the service",
                        ]);
                    }
            }
         
         public function CheckVehicle(Request $request)
            {
               try {
                //code...
                $id = $request->input('id');
                $today = Carbon::today()->toDateString();
                $vehicle = DailyKMCalculationModel::where('date',$today)->where('vehicle_id',$id)->first();
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
                        'success' => true,
                        'message' => "Both filled",
                    ]);
                }
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json([
                        'success' => true,
                        'message' => "Choose to fill",
                    ]);
                }
            }
    }
