<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\vehicle\DailyKMCalculationModel;
use Illuminate\Http\Request;
use App\Models\Vehicle\VehiclesModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Andegna\DateTime;
class Daily_KM_Calculation extends Controller
    {
        public function displayPage()
            {
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                $vehicle = VehiclesModel::get();
                $TodaysDate = DailyKMCalculationModel::where('created_at',$ethio_date)->latest()->get();
                return view('Vehicle.DailKmForm',compact('vehicle','TodaysDate'));
            }
        public function ConvertToEthiopianDate($today)
            {
                $ethiopianDate = new DateTime($today);
        
                // Format the Ethiopian date
                $formattedDate = $ethiopianDate->format('Y-m-d');
        
                // Display the Ethiopian date
                return $formattedDate;
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
                    $today = Carbon::today();
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
                    $today = Carbon::today();
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
                            return redirect()->back()->with('error_message',
                                 $validator->errors(),
                            );
                        }
                    $today = Carbon::today();
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
                    $today = Carbon::today();
                    $ethio_date = $this->ConvertToEthiopianDate($today);
                    $vehicle = DailyKMCalculationModel::where('created_at',$ethio_date)->where('vehicle_id',$id)->first();
                    
                    return response()->json([
                        'success' => false,
                        'vehicle' => $vehicle,
                    ]);
            }
         public function CheckVehicle(Request $request)
            {
               try {
                //code...
                $id = $request->input('id');
                $today = Carbon::today();
                $ethio_date = $this->ConvertToEthiopianDate($today);
                $vehicle = DailyKMCalculationModel::where('created_at',$ethio_date)->where('vehicle_id',$id)->first();
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
