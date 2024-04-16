<?php

namespace App\Helpers;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class Helper {

    public static function admin_ticket_activity()
    {
        $startDate = Carbon::now()->subDays(10)->startOfDay();
        $endDate = Carbon::today();
        $dailyDates = [];

        // Iterate over the last 10 days
        for ($i = 0; $i < 10; $i++) {
            // Calculate the date by subtracting $i days from the end date
            $date = $endDate->copy()->subDays($i);

            // Format the date as desired (with day and abbreviated month name)
            $formattedDate = $date->format('j M');

            // Add the formatted date to the array
            // $dailyDates[] = $formattedDate;
            $dailyDates[] = $formattedDate;
            
        }
        // Reverse the array to get the dates in ascending order
        $dailyDates = array_reverse($dailyDates);

        $createdCount = [];
        $inprogressCount = [];
        $solvedCount = [];

        // Generate the range of dates for the last 10 days
        $period = CarbonPeriod::create(Carbon::now()->subDays(9), Carbon::now());

        // Iterate over each day in the period
        foreach ($period as $date1) {
            // Format the date as YYYY-MM-DD
            $formattedDate = $date1->format('Y-m-d');

            // Retrieve the count of tickets created on this date
            $created = Ticket::whereDate('created_at', $formattedDate)->count();
            $inprogress = Ticket::where('status','3')->whereDate('created_at', $formattedDate)->count();
            $solved = Ticket::whereDate('solved_at', $formattedDate)->count();

            // Add the count to the formatted data array
            $createdCount[] = $created;
            $inprogressCount[] = $inprogress;
            $solvedCount[] = $solved;
        }

        // return $createdCounts;
        $data = [
            'last10Days' => $dailyDates,
            'createdCount' => $createdCount,
            'inprogressCount' => $inprogressCount,
            'solvedCount' => $solvedCount,
        ];

        return $data;
    }
    public static function admin_ticket_overview()
    {
        $createdCount = Ticket::where('status','1')->count();
        $inprogressCount = Ticket::where('status','3')->count();
        $solvedCount = Ticket::where('status','4')->count();

        // return $createdCounts;
        $data = [
            'createdCount' => $createdCount,
            'inprogressCount' => $inprogressCount,
            'solvedCount' => $solvedCount,
        ];

        return $data;
    }

    public static function admin_new_ticket_count()
    {
        if(Auth::user()->hasRole('technician')){
            $count = Ticket::where([['status', '=', 1]])->whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->count();
            
        }else{
            $count = Ticket::where([['status', '=', 1]])->count();
        }

        return $count;
    }

    public static function admin_inprogress_ticket_count()
    {
        if(Auth::user()->hasRole('technician')){
            $count = Ticket::where([['status', '=', 3]])->whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->count();
            
        }else{
            $count = Ticket::where([['status', '=', 3]])->count();
        }

        return $count;
    }
}