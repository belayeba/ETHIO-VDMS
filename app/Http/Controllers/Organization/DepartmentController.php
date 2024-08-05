<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\DepartmentsModel;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $departments = DepartmentsModel::all(); // Get all departments
        return view('departments.index', compact('departments')); // Pass the departments to the view
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
