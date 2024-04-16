<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function redirectUser(){

        if(auth()->user()->hasRole('superadmin')){
            return redirect()->route('admin.dashboard');
            // return redirect()->route('superadmin.dashboard');
        }
        
        if(auth()->user()->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        
        if(auth()->user()->hasRole('technician')){
            return redirect()->route('admin.tickets.index');
            // return redirect()->route('admin.dashboard');
        }

        if(auth()->user()->hasRole('user')){
            return redirect()->route('user.dashboard');
        }

    }
}
