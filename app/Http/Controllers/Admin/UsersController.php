<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:User Read|User Create|User Edit|User Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:User Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:User Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:User Delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();
        $files = File::get();
        return view('admin.users.create', compact('roles','files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'company'=>'sometimes',
            'password'=>'required',
            'files' => 'sometimes|nullable|array',
        ]);
        
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'company'=>$request->company,
            'password'=> Hash::make($request->password),
        ]);
        
        $user->syncRoles($request->roles);

        if($user){
            if (isset($validated['files'])) {
                $user->files()->sync($validated['files']);
            }else {
                $user->files()->sync([]);
            }
    
        }
        
        toastr()->success('User Created');
        return to_route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $tickets = Ticket::where([['user_id', '=', $user->id]])->latest()->get();
        return view('admin.users.show',compact('user','tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $files = File::get();
        $user->roles;
        return view('admin.users.edit',compact('user','roles','files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'phone' => 'required|unique:users,phone,'.$user->id.',id',
            'company'=>'sometimes',
            'files' => 'sometimes|nullable|array',
        ]);

        if($request->password != null){
            $request->validate([
                'password' => 'required'
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        if (isset($validated['files'])) {
            $user->files()->sync($validated['files']);
        }else {
            $user->files()->sync([]);
        }

        toastr()->success('User Updated');
        return to_route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $result = $user->delete();

        if($result){
            $user->files()->sync([]);
            toastr()->success('User Deleted');
        }else{
            toastr()->error('An error occured!');
        }
        return to_route('admin.users.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function technicianList()
    {
        $users = User::role('technician')->get();
        return view('admin.users.technicians',compact('users'));
    }

    /**
     * Display a listing of the resource.
     */
    public function usersList()
    {
        $users = User::role('user')->get();
        return view('admin.users.users',compact('users'));
    }
}
