<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\ClustersModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use Exception;

class ClusterController extends Controller {
    protected $dailyKmCalculation;

    public function __construct(Daily_KM_Calculation $dailyKmCalculation)
    {
        $this->dailyKmCalculation = $dailyKmCalculation;
    }
    // Display a listing of the resource.
    public function index() {
        $clusters = ClustersModel::all();

        return view( 'Cluster.index', compact( 'clusters' ) );
    }

    // Show the form for creating a new resource.

    public function create() {
        return view( 'cluster.create' );
    }

    // Store a newly created resource in storage.

    public function store( Request $request ) {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
           // 'created_by' => 'required',
        ] );
        if ($validation->fails()) 
        {
           return redirect()->back()->with('error_message',
               'Something went Wrong, Please use Text formats only.',
            );
        }
        try
        {
            $user = Auth::id();
            // Get the authenticated user's ID
            $today = \Carbon\Carbon::now();
            $ethiopianDate = $this->dailyKmCalculation->ConvertToEthiopianDate($today); 
            $request->merge(['created_by' => $user,'created_at' => $ethiopianDate]); 
            
            ClustersModel::create( $request->all() );
            return redirect()->back()->with('success_message',
            'Cluster created successfully.',);
        }
        catch (Exception $e)
        {
            return redirect()->back()->with('error_message',
            'Sorry, Something Went Wrong.',);
        }
       // return redirect()->route( 'cluster.index' )->with( 'success', 'Cluster created successfully.' );

    }

    // Display the specified resource.

    public function show( ClustersModel $cluster ) {
        $clusters = ClustersModel::get();
        return view( 'cluster.show', compact( 'clusters' ) );
    }

    // Show the form for editing the specified resource.

    public function edit( ClustersModel $cluster ) {
        return view( 'cluster.edit', compact( 'cluster' ) );
    }

    // Update the specified resource in storage.

    public function update( Request $request, ClustersModel $cluster ) {
        // dd( $request );
        $validation = Validator::make($request->all(),[
           'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
           // 'created_by' => 'required',
        ] );
        if ($validation->fails()) 
        {
           return redirect()->back()->with('error_message',
               'Something went Wrong, Please use Text formats only.',
            );
        }
        
        $user = Auth::id();
        // Get the authenticated user's ID
        $request->merge(['created_by' => $user]); 
        // dd($request);// Add the user's ID to the request data
        $cluster->update( $request->all() );

        return redirect()->back()->with( 'success', 'Cluster updated successfully.' );
    }

    // Remove the specified resource from storage.

    public function destroy( ClustersModel $cluster ) {
    try
    {
        $cluster->delete();
        return redirect()->back()->with( 'success', 'Cluster deleted successfully.' );
    }
    catch (Exception $e)
    {
        return redirect()->back()->with('error_message',
        'Sorry, Something Went Wrong.',);
    }
    }

}
