<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Permission Read|Permission Create|Permission Edit|Permission Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Permission Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Permission Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Permission Delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->get();
        return view('admin.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $request->validate([
            'name'=>'required',
        ]);

        $permission = Permission::create(['guard_name' => 'web','name'=>$request->name]);

        toastr()->success('Permission Created');
        return to_route('admin.permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->update(['name'=>$request->name]);

        toastr()->success('Permission updated');
        return to_route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        toastr()->success('Permission deleted');
        return to_route('admin.permissions.index');
    }
}
