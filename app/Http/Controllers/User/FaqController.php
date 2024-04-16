<?php

namespace App\Http\Controllers\User;

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


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faqcategory::latest()->get();
        return view('user.faqs.category',compact('faqs'));
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
        $faqcategory = Faqcategory::where('id',$id)->first();
        $faqs = Faq::where('category',$id)->latest()->get();
        return view('user.faqs.index',compact('faqs','faqcategory'));
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
