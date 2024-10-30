<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver\DriversModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DriverRegistrationController extends Controller
{
    //Page

    public function RegistrationPage()
    {
        $drivers = User::get();
        $data = DriversModel::get();

        return view('Driver.index', compact('drivers', 'data'));
    }
    // Create a new driver

    public function store(Request $request)
    {
        try {
            // dd( $request );
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|uuid|exists:users,id',
                'license_number' => 'required|string|max:255',
                'license_expiry_date' => 'required|date|after:today',
                'license_file' => 'required|file|mimes:pdf,jpg,jpeg',
                //'phone_number' => 'nullable|string|max:20|unique:drivers,phone_number',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $loged_user = Auth::id();

            $file = $request->file('license_file');

            $storagePath = storage_path('app/public/Drivers');
            if (! file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            $license = time().'_'.$file->getClientOriginalName();
            $file->move($storagePath, $license);
            DriversModel::create([
                'user_id' => $request->input('user_id'),
                'license_number' => $request->input('license_number'),
                'license_expiry_date' => $request->input('license_expiry_date'),
                'license_file' => $license,
                //'phone_number' => $request->input( 'phone_number' ),
                'register_by' => $loged_user,
                'notes' => $request->input('notes'),
            ]);

            return redirect()->back()->with('success_message', 'Driver created successfully.');
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
            //return redirect()->back()->with( 'error', 'Driver creation failed.' );
        }
    }

    // Get all drivers

    public function index()
    {
        try {
            $drivers = DriversModel::all();

            return response()->json($drivers);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Fetching drivers failed'], 500);
        }
    }

    // Get a specific driver by ID

    public function show($id)
    {
        try {
            $driver = DriversModel::findOrFail($id);

            return response()->json($driver);
        } catch (Exception $e) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

    }

    // Update a driver

    public function update(Request $request, $id)
    {
        try {
            $driver = DriversModel::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|uuid|exists:users,id',
                'license_number' => 'required|string|max:255',
                'license_expiry_date' => 'required|date|after:today',
                'license_file' => 'sometimes|required|file|mimes:pdf,jpg,jpeg',
                'phone_number' => 'required|string|max:20',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $file = $request->file('license_file');

            $storagePath = storage_path('app/public/Drivers');
            if (! file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            $license = time().'_'.$file->getClientOriginalName();
            $file->move($storagePath, $license);
            $driver->update([
                'user_id' => $request->input('user_id'),
                'license_number' => $request->input('license_number'),
                'license_expiry_date' => $request->input('license_expiry_date'),
                'status' => $request->input('status', 'active'),
                'license_file' => $license,
                'phone_number' => $request->input('phone_number'),
                'notes' => $request->input('notes'),
            ]);

            return redirect()->back()->with('success_message', 'Driver updated successfully.');
        } catch (Exception $e) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

    }

    // Delete a driver

    public function destroy($id)
    {
        try {
            $driver = DriversModel::findOrFail($id);
            $driver->delete();

            return redirect()->back()->with('success_message', 'Driver deleted successfully.');
        } catch (Exception $e) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

    }
}
