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
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class usercontroller extends Controller
{
    public function login(Request $request)
    {
        $response = Http::asForm()->post(config("services.keycloak.base_url").'realms/'.config("services.keycloak.realms").'/protocol/openid-connect/token/introspect', [
            'token' => $request->token,
            'client_id' => config("services.keycloak.client_id"),
            'client_secret' => config("services.keycloak.client_secret")
        ]);



        if($response->successful() && $response["active"])
        {
            $thisUser= User::where("email",$response["email"])->first();

            if($thisUser)
            {

                Auth::login($thisUser);

                return Redirect::to('/home');

            }

            return Redirect::to(config("services.keycloak.portal_url").'homepage')->with("error","You can not access this service!!");


        }
        else 
        {
            return Redirect::to(config("services.keycloak.portal_url").'homepage')->with("error","Failed to authenticate!!");
        }
    }
    public function list()
    {
        $users=User::get();
        return  view ('users.list',compact('users'));
    }

    public function searchUsers(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
        ]);
    
        $query = $request->input('q');
    if ($query !== null){
        // Perform the search
        $users = User::where('username', 'like', "%$query%")
            ->orWhere('first_name', 'like', "%$query%")
            ->orWhere('middle_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone_number', 'like', "%$query%")
            ->get();
    
        return response()->json($users);
    }
    else{
        $users = User::get();
        return response()->json($users); 
    }
    }
    
    public function list_show(Request $request)
    {
        $users = User::get();
        
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('first_name', function($row){
                return $row->first_name.' '.$row->middle_name.' '.$row->last_name;
            })
            ->addColumn('email', function($row){
                return $row->email;
            })
            ->addColumn('phone_number', function($row){
                return $row->phone_number;
            })
            ->addColumn('department_id', function($row) {
                if ($row->department) {
                    return $row->department->name;
                } else {
                    return 'No Department'; 
                }
            })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('d/m/Y');
            })
            ->addColumn('action', function($row){
                return '
                        <a href="' . route('user.update', ['id' => $row->id]) . '" class="btn btn-secondary rounded-pill" title="Edit"><i class="ri-edit-box-line"></i></a>
                        <button type="button" class="btn btn-danger rounded-pill reject-btn"  data-id="' . $row->id . '" title="Delete"><i class="ri-close-circle-line"></i></button>';
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
            $data['created_By'] = $currentUser;
            $user = User::create($data);
            $user->assignRole($request->input('roles'));

            return redirect()->route('user_list')->with('success_message', 'User is registered successfully');

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
        return view("users.edit",compact('users','roles','department'));

    }

    public function storeupdates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|uuid|exists:users,id',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => ['required','string',Rule::unique('users', 'username')->ignore($request->id),],
            'roles' => 'required|string',
            'department' => 'required|string|max:255',
            'email' => ['required','string','max:100',Rule::unique('users', 'email')->ignore($request->id),],
            'password' => 'nullable|string|min:8',
            'confirm' => 'nullable|string|min:8|same:password',
            'phone' => 'required|string',    
        ]);
        // If validation fails, return an error response
        if ($validator->fails()) 
            {
                $errorMessages = $validator->errors()->all();
                $errorString = collect($errorMessages)->implode(' ');
                return back()->with('error_message', $errorString);
            }

            // dd($request);

        try{
            $currentUser = auth()->user();
            $data = $request->all();
        
           // Retain the current password if none is provided
            if (!empty($request->input('password'))) {
                $data['password'] = Hash::make($request->input('password'));
            }

            // Fetch the user to update
            $user = User::findOrFail($request->id);

            // Update the user's information
            $user->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'department_id' => $data['department'],
                'phone_number' => $data['phone'],
                'password' => $data['password'] ?? $user->password, // Keep existing password if none is provided
                'updated_by' => $currentUser->id,
            ]);

            // Sync roles
            if ($request->has('roles')) {
                $user->syncRoles($request->input('roles'));
            }
            return redirect()->route('user_list')->with('success_message', 'User is updated successfully');

        }
        catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }   
    
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid|exists:users,id',   
        ]);
   
        if ($validator->fails()) 
            {
                return back()->with('error_message', 'Something went Wrong!');
            }

        try {
            //code...
            $id=$request->input('user_id');
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('success_message', 'User Removed!');
        } catch (\Throwable $th) {
            
            return back()->with('error_message', 'Unable to Process!');
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

