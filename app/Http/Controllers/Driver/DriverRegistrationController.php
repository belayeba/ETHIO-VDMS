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

class DriverRegistrationController extends Controller {
    //Page
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
        {
            $this->dailyKmCalculation = $dailyKmCalculation;
        }
    public function RegistrationPage() {
        $drivers = User::get();
        $data = DriversModel::get();
    
        return view( 'Driver.index', compact( 'drivers', 'data' ) );
    }
    // Create a new driver

    public function store( Request $request ) {
        try {
            // dd( $request->input( 'expiry_date' ));
            $validator = Validator::make( $request->all(), [
                'user_id' => 'required|uuid|exists:users,id',
                'license_number' => 'required|string|max:255',
                'expiry_date' => 'required|date',
                'license_file' => 'required|file|mimes:pdf,jpg,jpeg',
                'notes' => 'nullable|string',
            ] );

            if ( $validator->fails() ) {
                return redirect()->back()->with('error_message','Warning! You are denied the service',);
            }
            $loged_user = Auth::id();

            $file = $request->file( 'license_file' );

            $storagePath = storage_path( 'app/public/Drivers' );
            if ( !file_exists( $storagePath ) ) {
                mkdir( $storagePath, 0755, true );
            }
            $license = time() . '_' . $file->getClientOriginalName();
            $file->move( $storagePath, $license );
            $today = \Carbon\Carbon::today();
           $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            DriversModel::create( [
                'user_id' => $request->input( 'user_id' ),
                'license_number' => $request->input( 'license_number' ),
                'license_expiry_date' => $request->input( 'expiry_date' ),
                'license_file' => $license,
                'register_by' => $loged_user,
                'notes' => $request->input( 'notes' ),
                'created_at' => $ethiopianDate
            ] );
            $user = User::find($request->user_id);
            $message = "You are registered as driver ";
            $subject = "Driver Registration";
            $url = "#";
            $user->NotifyUser($message,$subject,$url);
            return redirect()->back()->with('success_message','Driver created successfully.',);
        } catch ( Exception $e ) {
            return redirect()->back()->with('error_message','Sorry, Something went wrong',);
    
        }
    }

    // Get all drivers

    public function index() {
        try {
            $drivers = DriversModel::all();
            return response()->json( $drivers );
        } catch ( \Exception $e ) {
            return redirect()->back()->with('error_message','Fetching Drivers failed',);
        }
    }

    // Get a specific driver by ID

    public function show( $id ) {
        try {
            $driver = DriversModel::findOrFail( $id );
            return response()->json( $driver );
        } catch ( Exception $e ) {
            return redirect()->back()->with('error_message','Driver not found',);
        }

    }

    // Update a driver

    public function update( Request $request, $id ) {
        try {
            $driver = DriversModel::findOrFail( $id );

            $validator = Validator::make( $request->all(), [
                'user_id' => 'required|uuid|exists:users,id',
                'license_number' => 'required|string|max:255',
                'license_expiry_date' => 'required|date|after:today',
                'license_file' => 'sometimes|required|file|mimes:pdf,jpg,jpeg',
                'phone_number' => 'required|string|max:20',
                'notes' => 'nullable|string',
            ] );

            if ( $validator->fails() ) {
                return redirect()->back()->with('error_message','All fields are required',);
            }

            $file = $request->file( 'license_file' );

            $storagePath = storage_path( 'app/public/Drivers' );
            if ( !file_exists( $storagePath ) ) {
                mkdir( $storagePath, 0755, true );
            }
            $license = time() . '_' . $file->getClientOriginalName();
            $file->move( $storagePath, $license );
            $driver->update( [
                'user_id' => $request->input( 'user_id' ),
                'license_number' => $request->input( 'license_number' ),
                'license_expiry_date' => $request->input( 'license_expiry_date' ),
                'status' => $request->input( 'status', 'active' ),
                'license_file' => $license,
                'phone_number' => $request->input( 'phone_number' ),
                'notes' => $request->input( 'notes' ),
            ] );
            return redirect()->back()->with('success_message','Driver updated successfully.',);
        } catch ( Exception $e ) {
            return redirect()->back()->with('error_message','Driver not found',);
        }

    }

    // Delete a driver

    public function destroy( $id ) {
        try {
            $driver = DriversModel::findOrFail( $id );
            $driver->delete();
            return redirect()->back()->with('success_message','Driver deleted successfully.',);
        } catch ( Exception $e ) {
            return redirect()->back()->with('error_message','Driver not found',);
        }

    }
}
