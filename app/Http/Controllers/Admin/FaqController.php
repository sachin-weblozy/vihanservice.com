<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Faqcategory;
use Illuminate\Http\Request;

class FaqController extends Controller
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
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index',compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faqcategories = Faqcategory::get();
        return view('admin.faqs.create', compact('faqcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'=>'required',
            'question'=>'required',
            'answer'=>'required',
        ]);
        
        $faq = Faq::create(['category' => $request->category,'question' => $request->question,'answer'=>$request->answer]);

        toastr()->success('FAQ Created');
        return to_route('admin.faqs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return view('admin.faqs.show',compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $faqcategories = Faqcategory::get();
        return view('admin.faqs.edit',compact('faq','faqcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'category'=>'required',
            'question'=>'required',
            'answer'=>'required',
        ]);

        $faq->update(['category' => $request->category,'question' => $request->question,'answer'=>$request->answer]);

        toastr()->success('FAQ updated');
        return to_route('admin.faqs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        toastr()->success('FAQ deleted');
        return to_route('admin.faqs.index');
    }
}
