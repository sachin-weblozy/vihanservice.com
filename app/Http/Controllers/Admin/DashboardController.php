<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class DashboardController extends Controller
{
    public function home(){

        if(Auth::user()->hasRole('technician')){
            $tickets = Ticket::whereHas('technicians', function($query) {$query->where('user_id', Auth::id());})->latest()->get();

            $unsolvedCount = Ticket::whereHas('technicians', function($query) {$query->where('user_id', Auth::id());})->where([['status', '!=', 4]])->count();
            $solvedCount = Ticket::whereHas('technicians', function($query) {$query->where('user_id', Auth::id());})->where([['status', '=', 4]])->count();
            $totalCount = Ticket::whereHas('technicians', function($query) {$query->where('user_id', Auth::id());})->count();
            
        }else{
            $unsolvedCount = Ticket::where([['status', '!=', 4]])->count();
            $solvedCount = Ticket::where([['status', '=', 4]])->count();
            $totalCount = User::count();
        }

        return view('admin.index', compact('unsolvedCount','solvedCount','totalCount'));
    }
}
