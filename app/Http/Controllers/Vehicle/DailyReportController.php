<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
//use App\Models\Report;

class DailyReportController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        //$clusters = ClustersModel::all();
        // dd($clusters);
        return view('Vehicle.dailyReport');
    }
}