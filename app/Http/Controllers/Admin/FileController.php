<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

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
        $files = File::latest()->get();
        return view('admin.files.index',compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'files'=>'required',
        ]);
        $files = [];
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($request->hasFile('files')) {

            $files = [];
            $filePath = 'uploads/files/'.$currentYear.'/'.$currentMonth;

            foreach($request->file('files') as $file)
            {
                $originalName = $file->getClientOriginalName();
                $fileName = time().rand(1,99).'_'.$originalName;
                $fileType = $file->extension();
                $upload = $file->move($filePath, $fileName);
                $insert = File::create(['name' => $fileName,'type'=>$fileType,'path'=>$filePath]);
            }
        }

        toastr()->success('Files Uploaded');
        return to_route('admin.files.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
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
    public function destroy(File $file)
    {
        $filePath = public_path($file->path.'/'.$file->name);
        $result = unlink($filePath);
        if($result){
            $file->delete();
            toastr()->success('Files Deleted');
        }else{
            toastr()->success('An error occurred');
        }
        return to_route('admin.files.index');
    }
}
