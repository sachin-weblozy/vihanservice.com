<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Video Read|Video Create|Video Edit|Video Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Video Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Video Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Video Delete', ['only' => ['destroy']]);
    }

    protected function getDefaultGuardName(): string { return 'web'; }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->get();
        return view('admin.videos.index',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.create');
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
            $filePath = 'uploads/videos/'.$currentYear.'/'.$currentMonth;

            foreach($request->file('files') as $file)
            {
                $originalName = $file->getClientOriginalName();
                $fileName = time().rand(1,99).'_'.$originalName;
                $fileType = $file->extension();
                $upload = $file->move($filePath, $fileName);
                $insert = Video::create(['name' => $fileName,'type'=>$fileType,'path'=>$filePath]);
            }
        }

        toastr()->success('Video Uploaded');
        return to_route('admin.videos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $file)
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
    public function destroy(Video $video)
    {
        $filePath = public_path($video->path.'/'.$video->name);
        $result = unlink($filePath);
        if($result){
            $video->delete();
            toastr()->success('Files Deleted');
        }else{
            toastr()->success('An error occurred');
        }
        return to_route('admin.videos.index');
    }
}
