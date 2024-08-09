<?php

namespace App\Http\Controllers\Vehicle;
use App\Http\Controllers\Controller;
use App\Models\Vehicle\VehicleModel;
use App\Models\Vehicle\VehicleInfo;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        // dd("It is vehicle index baby ;)");
        $vehicles = Vehicle::with(['user', 'driver', 'details'])->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vin' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'plate_number' => 'required|string|max:255',
            'registration_date' => 'required|date',
            'mileage' => 'required|integer',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_category' => 'required|string|max:255',
            'fuel_amount' => 'required|numeric',
            'last_service' => 'nullable|date',
            'next_service' => 'nullable|date',
            'registered_by' => 'nullable|uuid|exists:users,id',
            'driver_id' => 'nullable|uuid|exists:drivers,driver_id',
            'fuel_type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $vehicle = Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            // validation rules similar to store method
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }

    /**
     * Display the details for a specific vehicle.
     *
     * @param  Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function showDetails(Vehicle $vehicle)
    {
        $details = $vehicle->details()->with('user', 'driver')->get();
        return view('vehicles.details.index', compact('vehicle', 'details'));
    }

    /**
     * Show the form for creating a new vehicle detail.
     *
     * @param  Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function createDetail(Vehicle $vehicle)
    {
        return view('vehicles.details.create', compact('vehicle'));
    }

    /**
     * Store a newly created vehicle detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'detail' => 'required|string|max:2000',
            'register_by' => 'required|uuid|exists:users,id',
            'date' => 'required|date',
            'mileage' => 'required|integer',
            'driver_id' => 'required|uuid|exists:drivers,driver_id',
        ]);

        $validated['vehicle_id'] = $vehicle->vehicle_id;

        VehicleDetail::create($validated);

        return redirect()->route('vehicles.details.index', $vehicle)->with('success', 'Vehicle detail created successfully.');
    }

    /**
     * Show the form for editing a specific vehicle detail.
     *
     * @param  Vehicle  $vehicle
     * @param  VehicleDetail  $detail
     * @return \Illuminate\Http\Response
     */
    public function editDetail(Vehicle $vehicle, VehicleDetail $detail)
    {
        return view('vehicles.details.edit', compact('vehicle', 'detail'));
    }

    /**
     * Update the specified vehicle detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Vehicle  $vehicle
     * @param  VehicleDetail  $detail
     * @return \Illuminate\Http\Response
     */
    public function updateDetail(Request $request, Vehicle $vehicle, VehicleDetail $detail)
    {
        $validated = $request->validate([
            'detail' => 'required|string|max:2000',
            'register_by' => 'required|uuid|exists:users,id',
            'date' => 'required|date',
            'mileage' => 'required|integer',
            'driver_id' => 'required|uuid|exists:drivers,driver_id',
        ]);

        $detail->update($validated);

        return redirect()->route('vehicles.details.index', $vehicle)->with('success', 'Vehicle detail updated successfully.');
    }

    /**
     * Remove the specified vehicle detail from storage.
     *
     * @param  Vehicle  $vehicle
     * @param  VehicleDetail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroyDetail(Vehicle $vehicle, VehicleDetail $detail)
    {
        $detail->delete();

        return redirect()->route('vehicles.details.index', $vehicle)->with('success', 'Vehicle detail deleted successfully.');
    }
}
