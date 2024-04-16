<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketIds = Ticket::where('user_id', Auth::id())->pluck('id');
        $reports = Report::whereIn('ticket_id', $ticketIds)->get();

        return view('user.tickets.reports.index',compact('reports'));
    }

    /**
     * Display the specified resource.
     */
    public function show($ticketid)
    {
        $ticket = Ticket::findOrFail($ticketid);
        $data = [
            'report'=>$ticket->report,
        ];
        $filename = 'report_'.$ticket->report->report_number.'.pdf';
        $pdf = Pdf::loadView('pdf.ic_report', $data);
        return $pdf->stream($filename);
    }
}
