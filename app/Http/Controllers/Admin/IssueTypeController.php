<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issuetype;
use Illuminate\Http\Request;

class IssueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Category Read|Category Create|Category Edit|Category Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Category Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Category Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Category Delete', ['only' => ['destroy']]);
    }

    protected function getDefaultGuardName(): string { return 'web'; }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issuetypes = Issuetype::where('parent_id', null)->latest()->get();
        return view('admin.issue_types.index',compact('issuetypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.issue_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $request->validate(['name'=>'required']);

        $result = Issuetype::create([
            'name'=>$request->name,
        ]);
        
        if($result){
            toastr()->success('Issue Type Created');
            return to_route('admin.issue-types.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $issuetype = Issuetype::where('id',$id)->first();
        return view('admin.issue_types.edit',compact('issuetype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $issuetype = Issuetype::where('id',$id)->first();
        $result = $issuetype->update(['name'=>$request->name]);
        
        if($result){
            toastr()->success('Issue Type Updated');
            return to_route('admin.issue-types.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $issuetype = Issuetype::where('id',$id)->first();
        $result = $issuetype->delete();
        if($result){
            toastr()->success('Issue Type Deleted');
        }else{
            toastr()->error('An error occured!');
        }
        return to_route('admin.issue-types.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function show($id)
    {
        $issuetype = Issuetype::where('id', $id)->first();
        $specifications = Issuetype::with('subspecs')->where('parent_id', $id)->latest()->get();
        return view('admin.issue_types.specs.index',compact('issuetype','specifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function specscreate($id)
    {
        $issuetype = Issuetype::where('id', $id)->first();
        return view('admin.issue_types.specs.create',compact('issuetype'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function specsstore(Request $request, $issuetypeid)
    { 
        $issuetype= Issuetype::where('id', $issuetypeid)->first();

        $request->validate([
            'specs'=>'required',
            'subspecs'=>'sometimes',
        ]);

        $specResult = Issuetype::create([
            'name'=>$request->specs,
            'parent_id'=>$issuetype->id,
            'type'=>1,
        ]);

        if($specResult){
            // Add sub specification 
            if($request->subspecs){
                foreach ($request->subspecs as $key => $value) {
                    $subspecResult = Issuetype::create([
                        'name'=>$value,
                        'parent_id'=>$specResult->id,
                        'type'=>2,
                    ]);
                }
            }
            toastr()->success('Issue Specifications Created');
            return to_route('admin.issue-types.show',$issuetype->id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function specsedit($id)
    {
        $specification = Issuetype::with('subspecs')->where('id',$id)->first();
        $issuetype = $specification->parent;
        return view('admin.issue_types.specs.edit',compact('issuetype','specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function specsupdate(Request $request, $id)
    {

        $request->validate([
            'specs'=>'required',
            'subspecs'=>'sometimes',
        ]);

        $specification = Issuetype::where('id',$id)->first();
        $issuetype = $specification->parent;
        $specResult = $specification->update(['name'=>$request->specs]);
        
        if($specResult){
            toastr()->success('Issue Specifications Updated');
            return to_route('admin.issue-types.show',$issuetype->id);
        }
    }

    // FOR SUB SPECS 
    /**
     * Display a listing of the resource.
     */
    public function subSpecsIndex($issuetypeid,$specsid)
    {
        $issuetype = Issuetype::where('id', $issuetypeid)->first();
        $spec = Issuetype::where([['parent_id', '=', $issuetypeid],['id', '=', $specsid]])->first();
        $subspecs = Issuetype::where([['parent_id', '=', $specsid],['type', '=', 2]])->get();
        return view('admin.issue_types.specs.subspecs.index',compact('issuetype','spec','subspecs'));
    }

    /**
     * Display a listing of the resource.
     */
    public function subSpecsCreate($issuetypeid,$specsid)
    {
        $issuetype = Issuetype::where('id', $issuetypeid)->first();
        $spec = Issuetype::where([['parent_id', '=', $issuetypeid],['id', '=', $specsid]])->first();
        return view('admin.issue_types.specs.subspecs.create',compact('issuetype','spec'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function subSpecsStore(Request $request, $id)
    {

        $request->validate([
            'subspec'=>'required',
        ]);

        $spec = Issuetype::where('id',$id)->first();
        $issuetype = $spec->parent;
        $subSpecResult = Issuetype::create([
            'name'=>$request->subspec,
            'parent_id'=>$id,
            'type'=>2,
        ]);
        
        if($subSpecResult){
            toastr()->success('Issue Sub Specifications Created');
            return to_route('admin.issue-types.subspecs.index',['issueid'=>$issuetype->id,'specsid'=>$spec->id]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function subSpecsEdit($issuetypeid,$specid,$subspecid)
    {
        $issuetype = Issuetype::where('id', $issuetypeid)->first();
        $spec = Issuetype::where([['parent_id', '=', $issuetypeid],['id', '=', $specid]])->first();
        $subspec = Issuetype::where([['id', '=', $subspecid],['type', '=', 2]])->first();
        return view('admin.issue_types.specs.subspecs.edit',compact('issuetype','spec','subspec'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function subSpecsUpdate(Request $request, $id)
    {

        $request->validate([
            'subspec'=>'required',
        ]);

        $subspec = Issuetype::where('id',$id)->first();
        $spec = $subspec->parent;
        $issuetype = $spec->parent;
        $subSpecResult = $subspec->update(['name'=>$request->subspec]);
        
        if($subSpecResult){
            toastr()->success('Issue Sub Specifications Updated');
            return to_route('admin.issue-types.subspecs.index',['issueid'=>$issuetype->id,'specsid'=>$spec->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function subSpecsdestroy ($subspecid)
    {
        $subspec = Issuetype::where('id',$subspecid)->first();
        $result = $subspec->delete();
        if($result){
            toastr()->success('SubSpecification deleted');
        }else{
            toastr()->error('An error occurred');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function specsdestroy ($specid)
    {
        $spec = Issuetype::where('id',$specid)->first();
        $result = $spec->delete();
        if($result){
            toastr()->success('Specification deleted');
        }else{
            toastr()->error('An error occurred');
        }
        return redirect()->back();
    }


}
