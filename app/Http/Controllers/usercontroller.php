<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Organization\DepartmentsModel; 
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
        $users = User::get();
        
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('first_name', function($row){
                return $row->first_name;
            })
            ->addColumn('email', function($row){
                return $row->email;
            })
            ->addColumn('phone_number', function($row){
                return $row->phone_number;
            })
            ->addColumn('department_id', function($row){
                return $row->department_id;
            })
            ->addColumn('created_at', function($row){
                return $row->created_at;
            })
            ->addColumn('action', function($row){
                return '<button id="acceptButton" type="button" class="btn btn-info rounded-pill" title="show"><i class=" ri-eye-line"></i></button>
                         <a href="' . route('user.update', ['id' => $row->id]) . '" class="btn btn-secondary rounded-pill" title="Edit"><i class="ri-edit-box-line"></i></a>
                        <button type="button" class="btn btn-danger rounded-pill" title="Delete"><i class="ri-close-circle-line"></i></button>';
            })
            ->rawColumns(['first_name','email','phone_number','department_id','created_at','action'])
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
        $department= DepartmentsModel::get();
        return view('users.create', compact('roles','department'));
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


        }
        catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }   
    
    }

    /**
     * update a specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function update($id)
    {
        $users = user::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $department= DepartmentsModel::get();
        // $Requested = VehicleTemporaryRequestModel::with('peoples', 'materials')
        //                 ->findOrFail($id);
        // dd($users);
        return view("users.edit",compact('users','roles','department'));
    }

    public function storeupdates(Request $request)
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
     * Show the form for editing the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    
    public function profile()
     {

        $user=Auth::id();
        $users = user::findOrFail($user);
        return  view ('users.profile',compact('users'));

     }

      /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    
    public function profile_save( Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string',
            'confirm_password' => 'required|string|same:new_password',
        ] );
        
        if ($validator->fails()) 
        {
            return redirect()->back()->with('error_message',
                 $validator->errors(),
            );
        }

        try {
            //code...
            $id=Auth::id();
            $users = user::findOrFail($id);

            $oldpassword = $request->input('old_password');

            $newPassword = $request->input('new_password');

            if (Hash::check($oldpassword, $users->password))
            {
                User::whereId($id)->update(['password' => Hash::make($newPassword)]);
                return redirect()->back()->with("success_message", "Your password has been changed successfully");
            }
            else{

                return redirect()->back()->with('error_message','Old password didn\'t match!');
            }

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error_message','Something went wrong!');
        }

    }
    




}

