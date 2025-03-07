<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;

class DriverRegistrationController extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function RegistrationPage()
    {
        $drivers = User::get();
        $data = DriversModel::get();

        return view('Driver.index', compact('drivers', 'data'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|uuid|exists:users,id',
                'license_number' => 'required|string|max:255',
                'expiry_date' => 'required|date',
                'license_file' => 'required|file|mimes:pdf,jpg,jpeg',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error_message', 'Warning! You are denied the service',);
            }
            $loged_user = Auth::id();

            $file = $request->file('license_file');

            $storagePath = storage_path('app/public/Drivers');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            $license = time() . '_' . $file->getClientOriginalName();
            $file->move($storagePath, $license);
            $today = \Carbon\Carbon::now();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today);
            DriversModel::create([
                'user_id' => $request->input('user_id'),
                'license_number' => $request->input('license_number'),
                'license_expiry_date' => $request->input('expiry_date'),
                'license_file' => $license,
                'register_by' => $loged_user,
                'notes' => $request->input('notes'),
                'created_at' => $ethiopianDate
            ]);
            $user = User::find($request->user_id);
            $message = "You are registered as driver ";
            $subject = "Driver Registration";
            $url = "#";
            $user->NotifyUser($message, $subject, $url);
            return redirect()->back()->with('success_message', 'Driver created successfully.',);
        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'Sorry, Something went wrong',);
        }
    }

    public function index()
    {
        try {
            $drivers = DriversModel::all();
            return response()->json($drivers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'Fetching Drivers failed',);
        }
    }

    public function show($id)
    {
        try {
            $driver = DriversModel::findOrFail($id);
            return response()->json($driver);
        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'Driver not found',);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $driver = DriversModel::findOrFail($id);

            $rules = [
                'driver_id' => 'uuid|exists:drivers,driver_id',
                'license_number' => 'string|max:255',
                'license_expiry_date' => 'date|after:today',
                'license_file' => 'file|mimes:pdf,jpg,jpeg',
                'notes' => 'nullable|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->with('error_message', 'Invalid input.');
            }

            $updateData = array_filter($request->only(['driver_id', 'license_number', 'license_expiry_date', 'notes']));

            if ($request->hasFile('license_file')) {
                $file = $request->file('license_file');

                $storagePath = storage_path('app/public/Drivers');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }

                $license = time() . '_' . $file->getClientOriginalName();
                $file->move($storagePath, $license);

                $updateData['license_file'] = $license;
            }

            $driver->update($updateData);

            return redirect()->back()->with('success_message', 'Driver updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'Driver not found.');
        }
    }

    public function updateStatus(Request $request)
    {
        $itemId = $request->input('id');
        $status = $request->input('status');


        $item = DriversModel::find($itemId);
        if ($item) {
            if ($status == 'active' || $status == 'inactive') {
                $item->status = $status;
                $item->save();

                session()->flash('success_message', 'Status updated successfully');
                return response()->json(['message' => 'Status updated successfully']);
            }
        }

        session()->flash('error_message', 'Item not found');
        return response()->json(['message' => 'Item not found'], 404);
    }

    public function destroy($id)
    {
        try {
            $driver = DriversModel::findOrFail($id);
            $driver->delete();
            return redirect()->back()->with('success_message', 'Driver deleted successfully.',);
        } catch (Exception $e) {
            return redirect()->back()->with('error_message', 'Driver not found',);
        }
    }
}
