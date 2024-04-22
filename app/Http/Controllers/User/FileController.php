<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:File Read|File Create|File Edit|File Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:File Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:File Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:File Delete', ['only' => ['destroy']]);
    }

    protected function getDefaultGuardName(): string { return 'web'; }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::whereHas('user', function($query) {
            $query->where('user_id', Auth::id())->where('type','png')
            ->orWhere('type','jpg')
            ->orWhere('type','webp')
            ->orWhere('type','pdf')
            ->orWhere('type','docx');
        })->latest()->get();

        return view('user.files.index',compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $file = File::where('id',decrypt($id))->first();
        $filePath = asset($file->path.'/'.$file->name);
        return redirect($filePath);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
