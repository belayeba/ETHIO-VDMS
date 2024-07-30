<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\ClustersModel;
use Illuminate\Http\Request;

class ClustersController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $clusters = ClustersModel::all();
        return view('clusters.index', compact('clusters'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('clusters.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ClustersModel::create($request->all());

        return redirect()->route('clusters.index')->with('success', 'Cluster created successfully.');
    }

    // Display the specified resource.
    public function show(ClustersModel $cluster)
    {
        return view('clusters.show', compact('cluster'));
    }

    // Show the form for editing the specified resource.
    public function edit(ClustersModel $cluster)
    {
        return view('clusters.edit', compact('cluster'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, ClustersModel $cluster)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cluster->update($request->all());

        return redirect()->route('clusters.index')->with('success', 'Cluster updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(ClustersModel $cluster)
    {
        $cluster->delete();

        return redirect()->route('clusters.index')->with('success', 'Cluster deleted successfully.');
    }
}
