<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Faqcategory;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:FAQ Read|FAQ Create|FAQ Edit|FAQ Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:FAQ Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:FAQ Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:FAQ Delete', ['only' => ['destroy']]);
    }

    protected function getDefaultGuardName(): string { return 'web'; }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faqcategory::latest()->get();
        return view('admin.faqs.category.index',compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required',
        ]);

        $faq = Faqcategory::create(['name' => $request->name]);

        toastr()->success('FAQ Category Created');
        return to_route('admin.faq-categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faqcategory $faq)
    {
        return view('admin.faqs.category.show',compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($faqcatid)
    {
        $faq = Faqcategory::where('id',$faqcatid)->first();
        return view('admin.faqs.category.edit',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $faqcatid)
    {
        $validated = $request->validate([
            'name'=>'required',
        ]);

        $faq = Faqcategory::where('id',$faqcatid)->first();
        $faq->update(['name' => $request->name]);

        toastr()->success('FAQ Category updated');
        return to_route('admin.faq-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($faqcatid)
    {
        $faq = Faqcategory::where('id',$faqcatid)->first();
        $faq->delete();
        toastr()->success('FAQ Category deleted');
        return to_route('admin.faq-categories.index');
    }
}
