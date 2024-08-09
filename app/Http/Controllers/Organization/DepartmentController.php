<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\DepartmentsModel;
use Illuminate\Http\Request;
use App\Models\Organization\ClustersModel;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $departments = DepartmentsModel::all(); // Get all departments
        $clusers = ClustersModel::all(); // Get all clusters
        // Pass the departments and clusters to the view
        return view('departments.index', compact('departments', 'clusters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('departments.create'); // Return the create view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'cluster_id' => 'required', // Ensure a valid cluster ID is used
        ]);
        $user = auth()->user()->id; // Get the authenticated user's ID
        $request->merge(['created_by' => $user]); // Add the user's ID to the request data
        // Create the department
        DepartmentsModel::create($request->all());
        // Redirect to the index page with a success message
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentsModel $department)
    {
        // Return the show view with the department data

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentsModel $department)
    {
        // Return the edit view with the department data
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentsModel $department)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $user = auth()->user()->id; // Get the authenticated user's ID
        $request->merge(['created_by' => $user]); // Add the user's ID to the request data
        // Update the department
        $department->update($request->all());
        // Redirect to the index page with a success message
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentsModel $department)
    {
        // Delete the department
        $department->delete();
        // Redirect to the index page with a success message
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

}
