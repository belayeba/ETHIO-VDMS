<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use App\Models\Vehicle\VehiclesModel;
use App\Models\Vehicle\VehiclePermanentlyRequestModel;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
        {
            $tempReq = VehicleTemporaryRequestModel::count();
            $permReq = VehiclePermanentlyRequestModel ::count();
            $vehicles = VehiclePermanentlyRequestModel:: count();
            $users = user::count();
            $user= Auth::id();
            return view('home',compact('tempReq','permReq','vehicles','users','user'));
        }

     public function info()
        {
            $tempReq = VehicleTemporaryRequestModel::count();
            $permReq = VehiclePermanentlyRequestModel ::count();
            $vehicles = VehiclePermanentlyRequestModel:: count();
            $users = user::count();
            return view('homeinfo',compact('tempReq','permReq','vehicles','users'));
        }
}
