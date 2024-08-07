<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\ClustersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClusterController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $clusters = ClustersModel::all();
        // dd($clusters);
        return view('Cluster.show', compact('clusters'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('cluster.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // $user = auth()->user()->id; // Get the authenticated user's ID
        $user = "123e4567-e89b-12d3-a456-426614174000";
        $request->merge(['created_by' => $user]); // Add the user's ID to the request data
        // ClustersModel::create($request->all());
        DB::table('clusters')->insert([
            'cluster_id' => Str::uuid(),
            'name' => $request->name,
            'created_by' => $user,
            ]);
        return redirect()->route('cluster.show')->with('success', 'Cluster created successfully.');
    }

    // Display the specified resource.
    public function show(ClustersModel $cluster)
    {
        return view('cluster.show', compact('cluster'));
    }

    // Show the form for editing the specified resource.
    public function edit(ClustersModel $cluster)
    {
        return view('cluster.edit', compact('cluster'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, ClustersModel $cluster)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cluster->update($request->all());

        return redirect()->route('cluster.index')->with('success', 'Cluster updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(ClustersModel $cluster)
    {
        $cluster->delete();

        return redirect()->route('cluster.index')->with('success', 'Cluster deleted successfully.');
    }
    public function view(){
        return view('Cluster.show');
    }
    public function display(){
        return view('Department.index');
    }
    public function request(){
        return view('Maintenance.index');
    }
    public function fuel(){
        return view('Fuelling.index');
    }
    public function vehicle(){
        return view('Vehicle.index');
    }
}
