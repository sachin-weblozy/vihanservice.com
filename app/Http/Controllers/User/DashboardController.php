<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home(){

        $unsolvedCount = Ticket::where([['user_id', '=', Auth::id()],['status', '!=', 4]])->count();
        $solvedCount = Ticket::where([['user_id', '=', Auth::id()],['status', '=', 4]])->count();
        $totalCount = Ticket::where([['user_id', '=', Auth::id()]])->count();

        $recentTickets = Ticket::where([['user_id', '=', Auth::id()],['status', '!=', 4]])->latest()->get();

        return view('user.index',compact('unsolvedCount','solvedCount','totalCount','recentTickets'));
    }
}
