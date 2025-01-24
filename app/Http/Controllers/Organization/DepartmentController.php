<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\DepartmentsModel;
use Illuminate\Http\Request;
use App\Models\Organization\ClustersModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use Exception;

class DepartmentController extends Controller
{
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    public function index()
    {
        //
        $departments = DepartmentsModel::all(); // Get all departments
        $clusters = ClustersModel::all(); // Get all clusters
        // Pass the departments and clusters to the view
        return view('department.index', compact('departments', 'clusters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create'); // Return the create view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
            'cluster_id' => 'required|uuid|exists:clusters,cluster_id',
        ]);
        // If validation fails, return an error response
        if ($validator->fails()) 
            {
                return redirect()->back()->with('error_message','All fields are required, And use Text only.',);
            }

        $user = auth()->user()->id; // Get the authenticated user's ID
        $today = \Carbon\Carbon::now();
        $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
        $request->merge(['created_by' => $user,'created_at'=>$ethiopianDate]); // Add the user's ID to the request data
        // Create the department
        DepartmentsModel::create($request->all());
        // Redirect to the index page with a success message
        return redirect()->back()->with('success_message', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentsModel $department)
    {
        // Return the show view with the department data

        return view('department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentsModel $department)
    {
        // Return the edit view with the department data
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentsModel $department)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
            'cluster_id' => 'required|uuid|exists:clusters,cluster_id',
        ]);
        // If validation fails, return an error response
        if ($validator->fails()) 
            {
                return redirect()->back()->with('error_message','All fields are required, And use Text only.',);
            }
        $user = auth()->user()->id; // Get the authenticated user's ID
        $request->merge(['created_by' => $user]); // Add the user's ID to the request data
        // Update the department
        $department->update($request->all());
        // Redirect to the index page with a success message
        return redirect()->back()->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentsModel $department)
    {
    try
    {
        // Delete the department
        $department->delete();
        // Redirect to the index page with a success message
        return redirect()->back()->with('success', 'Department deleted successfully.');
    }
    catch (Exception $e)
    {
        return redirect()->back()->with('error_message',
        'Sorry, Something Went Wrong.',);
    }
    }
}
