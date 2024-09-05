<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\vehicle\DailyKMCalculationModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Daily_KM_Calculation extends Controller
    {
        public function displayPage()
            {
                $today = Carbon::today()->toDateString();
                //   $TodaysDate = DailyKMCalculationModel::where('date',$today)->latest()->get();
                return view('Vehicle.DailKmForm');
            }
        public function ReportPage()
            {
                    $dailkms = DailyKMCalculationModel::with('driver','vehicle','created')
                                ->latest()
                                ->take(50)
                                ->get();
                return view('Vehicle.dailyReport',compact('dailkms'));
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
                        'morning_km' => 'required|number',
                        'vehicle'=>'required|uuid|exists:vehicles,vehicle_id',
                        //'driver_id'=>'required|uuid|exists:drivers,driver_id'
                    ]);            
                    // If validation fails, return an error response
                    if ($validator->fails()) 
                        {
                            return response()->json([
                                'success' => false,
                                'message' => "All fields are required",
                            ]);
                        }
                    $id = Auth::id();
                    try
                        {
                            // Create Daily Km calculation
                            DailyKMCalculationModel::create([
                                'register_by'=>$id,
                                'driver_id'=>$request->driver_id,
                                'vehicle_id' => $request->vehicle,
                                'morining_km' => $request->morning_km,
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
                                'message' => 'Sorry, Something went wrong',
                            ]);
                        }
            }
        public function aftern_km(Request $request)
            {
                    // Validate the request
                    $validator = Validator::make($request->all(), [
                        'afternoon_km' => 'required|number',
                        'vehicle'=>'required|uuid|exists:vehicles,vehicle_id',
                        'driver_id'=>'required|uuid|exists:drivers,driver_id'
                    ]);            
                    // If validation fails, return an error response
                    if ($validator->fails()) 
                        {
                            return response()->json([
                                'success' => false,
                                'message' => "All fields are required",
                            ]);
                        }
                    $id = Auth::id();
                    try
                        {
                            // Create Daily Km calculation
                            DailyKMCalculationModel::create([
                                'register_by'=>$id,
                                'driver_id'=>$request->driver_id,
                                'vehicle_id' => $request->vehicle,
                                'afternoon_km' => $request->morning_km,
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
    }
