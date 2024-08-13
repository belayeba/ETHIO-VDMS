<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Fecades\Auth;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Hash;

class usercontroller extends Controller
{

    public function list()
    {
        $users=User::get();
        return  view ('users.list',compact('users'));
    }


    public function list_show(Request $request)
    {
        $users = User::select(['first_name', 'email', 'phone_number', 'department_id', 'created_at']);
        return DataTables::of($users)
            ->make(true);
    }
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|unique:users,username',
            'roles' => 'required|string',
            'department' => 'required|string|max:255',
            'email' => 'required|string|max:100|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm' => 'required|string|min:8|same:password',
            'phone' => 'required|string',    
        ]);
        // If validation fails, return an error response
        if ($validator->fails()) 
            {
                $errorMessages = $validator->errors()->all();
                $errorString = collect($errorMessages)->implode(' ');
                return back()->with('error_message', $errorString);
            }
        try{
            $currentUser = auth()->user();
            $data = $request->all();
        
            $data['password'] = Hash::make($data['password']);
            $data['username']=$request->input('username') ?? null;
            $data['first_name'] = $request->input('first_name');
            $data['last_name'] = $request->input('last_name');
            $data['email'] = $request->input('email');
            $data['department_id'] = $request->input('department');
            $data['phone_number'] = $request->input('phone');
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

