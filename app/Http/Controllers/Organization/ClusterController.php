<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\ClustersModel;
use App\Models\User;
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
        return view('Cluster.index', compact('clusters'));
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
            // 'created_by' => 'required', // Ensure a valid user ID is used
        ]);
        $user = auth()->user()->id; // Get the authenticated user's ID
        // dd($user);
        $request->merge(['created_by' => $user]); // Add the user's ID to the request data
        ClustersModel::create($request->all());
        return redirect()->route('cluster.index')->with('success', 'Cluster created successfully.');
    
    }

    // Display the specified resource.
    public function show(ClustersModel $cluster)
    {
        $clusters=ClustersModel::get();
        return view('cluster.show', compact('clusters'));
    }

    // Show the form for editing the specified resource.
    public function edit(ClustersModel $cluster)
    {
        return view('cluster.edit', compact('cluster'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, ClustersModel $cluster)
    {
        // dd($cluster);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $user = auth()->user()->id; // Get the authenticated user's ID
        $request->merge(['created_by' => $user]); // Add the user's ID to the request data
        $cluster->update($request->all());
        
        return redirect()->route('cluster.index')->with('success', 'Cluster updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(ClustersModel $cluster)
    {
       
        $cluster->delete();

        return redirect()->route('cluster.index')->with('success', 'Cluster deleted successfully.');
    }
   
}
