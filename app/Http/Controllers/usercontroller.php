<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Fecades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;

class usercontroller extends Controller
{


    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
    
        return view('users.create', compact('roles'));
    }

    /**
     * Store a new user in the storage.
     *
     * @param App\Http\Requests\UsersFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // dd($request);
    try{
        $currentUser = auth()->user();
        $data = $request->all();
       
        $data['password'] = Hash::make($data['password']);
        $data['username']=$request->input('username') ?? null;
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['email'] = $request->input('email');
        $user = User::create($data);
        $user->assignRole($request->input('roles'));

        dd('success');

    }
    catch (Exception $exception) {
        return back()->withInput()
            ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
    }   
    
}

    /**
     * Display the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
   

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    



}

