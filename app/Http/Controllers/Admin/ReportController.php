<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewReportMail;
use App\Jobs\SendTicketAssignMailUser;
use App\Jobs\SendTicketSolvedMailUser;
use App\Jobs\SendNewTicektMailAdmin;
use App\Jobs\SendNewTicektMailUser;
use App\Mail\AdminNewReportMail;
use App\Models\Comment;
use App\Models\Issuetype;
use App\Models\Report;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->hasRole('technician')){
            $ticketIds = Ticket::whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->pluck('id');
            $reports = Report::whereIn('ticket_id', $ticketIds)->get();
            
        }else{
            $reports = Report::get();
        }

        return view('admin.tickets.report.index',compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($ticketid)
    {
        $ticket = Ticket::findOrFail($ticketid);

        if($ticket->type == 2 || $ticket->type == 3){
            return view('admin.tickets.report.create',compact('ticket'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'ticketid' => 'required',
            'machine_model' => 'required',
            'machine_serialno' => 'required',
            'name' => 'required',
            'invoice_number' => 'sometimes',
            'invoice_date' => 'sometimes',
            'purchase_order_number' => 'sometimes',
            'purchase_order_date' => 'sometimes',
            'service_mode' => 'sometimes',
            'asset_number' => 'sometimes',
            'installation_date' => 'required',
            'location' => 'sometimes',
            'warranty' => 'sometimes',
            'amc' => 'sometimes',
            'installation_note' => 'sometimes',
            'spare_parts' => 'sometimes',
            'customer_notes' => 'sometimes',
            'eng1name' => 'required',
            'eng1phone' => 'required',
            'eng1sign' => 'required',
            'cust1name' => 'required',
            'cust1phone' => 'required',
            'cust1sign' => 'required',
        ]);
        
        $ticket = Ticket::findOrFail($request->ticketid);
        
        $currentDate = new DateTime();
        $currentYear = intval($currentDate->format('Y'));
        // $currentYear = '2025';

        // Check if the current month is April or later
        if (intval($currentDate->format('m')) >= 4) {
            // If the current month is April or later, use the current year and add 1
            $financialYear = ($currentYear % 100) . ($currentYear % 100 + 1);
        } else {
            // If the current month is before April, use the previous year and current year
            $financialYear = ($currentYear - 1) % 100 . ($currentYear % 100);
        }

        $lastReport = Report::where('type',$ticket->type)->orderBy('id', 'desc')->first();

        if($lastReport){
            $reportNum = explode('/', $lastReport->report_number);
            if(count($reportNum) === 4) {
                list($rep_type, $rep_num, $rep_ver, $rep_date) = $reportNum;
                $parts = explode("-", $rep_type);
                
                if ($parts[1] == $financialYear) {
                    $nextReportNumber = $lastReport ? $rep_num + 1 : 1;
                }
                else{
                    $nextReportNumber = 1;
                }
            }
        }else{
            // If there are no existing reports, start with 1
            $nextReportNumber = $lastReport ? $lastReport->report_number + 1 : 1;
        }

        // Pad the report number with leading zeros to make it 9 characters long
        $paddedReportNumber = str_pad($nextReportNumber, 9, '0', STR_PAD_LEFT);
        //Today's Date
        $formattedDate = $currentDate->format('d.m.y');
        $type=null;


        if($ticket->type==2){
            $type = 2;
            $reportNumber = 'IC-'.$financialYear.'/'.$paddedReportNumber.'/R.1'.'/'.$formattedDate;
        }else if($ticket->type==3){
            $type = 3;
            $reportNumber = 'FS-'.$financialYear.'/'.$paddedReportNumber.'/R.1'.'/'.$formattedDate;
        }

        $warrantyPeriod = null;
        $extendedWarrantyDate = null;
        if($request->warranty==1){
            $warrantyDate = Carbon::createFromFormat('Y-m-d', $request->installation_date);
            $extendedWarrantyDate = $warrantyDate->addMonths(12);
        }else{
            $extendedWarrantyDate = null;
        }
        
        $existingReport = Report::where('ticket_id', $ticket->id)->first();

        if ($existingReport) {
            toastr()->error('A report already exists for same ticket.');
            return to_route('admin.tickets.show',$ticket->id);
        } else {
            $result = Report::create([
                'type' => $type,
                'createdby_id' => Auth::id(),
                'ticket_id' => $request->ticketid,
                'report_number' => $reportNumber,
                'machine_model' => $request->machine_model,
                'machine_serialno' => $request->machine_serialno,
                'cust_name' => $request->name,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'purchase_order' => $request->purchase_order_number,
                'purchase_order_date' => $request->purchase_order_date,
                'service_mode' => $request->service_mode,
                'asset_number' => $request->asset_number,
                'installation_date' => $request->installation_date,
                'location' => $request->location,
                'under_warranty' => $request->warranty,
                'warranty_period' => $extendedWarrantyDate,
                'amc_required' => $request->amc,
                'installation_notes' => $request->installation_note,
                'spare_parts' => $request->spare_parts,
                'customer_notes' => $request->customer_notes,
                'eng1_name' => $request->eng1name,
                'eng1_phone' => $request->eng1phone,
                'eng1_sign' => $request->eng1sign,
                'eng2_name' => $request->eng2name,
                'eng2_phone' => $request->eng2phone,
                'eng2_sign' => $request->eng2sign,
                'eng3_name' => $request->eng3name,
                'eng3_phone' => $request->eng3phone,
                'eng3_sign' => $request->eng3sign,
                'eng4_name' => $request->eng4name,
                'eng4_phone' => $request->eng4phone,
                'eng4_sign' => $request->eng4sign,
                'cust1_name' => $request->cust1name,
                'cust1_phone' => $request->cust1phone,
                'cust1_sign' => $request->cust1sign,
                'cust2_name' => $request->cust2name,
                'cust2_phone' => $request->cust2phone,
                'cust2_sign' => $request->cust2sign,
                'cust3_name' => $request->cust3name,
                'cust3_phone' => $request->cust3phone,
                'cust3_sign' => $request->cust3sign,
                'cust4_name' => $request->cust4name,
                'cust4_phone' => $request->cust4phone,
                'cust4_sign' => $request->cust4sign,
            ]);
    
            if($result){
                $usersemail = [];
                $users =  User::role(['superadmin' , 'admin'])->get()->pluck('email')->toArray();
                foreach($users as $user){
                    array_push($usersemail, $user);
                }
                if(Auth::user()->hasRole('technician')){
                    $usersemail[] = Auth::user()->email;
                }
    
                $details = [
                    'email' => $usersemail,
                    'ticketid' => $request->ticketid
                ];
    
    
                dispatch(new SendNewReportMail($details));
                
    
                toastr()->success('New Report Created');
                return to_route('admin.tickets.show',$ticket->id);
            }
        }
        
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($ticketid)
    {
        $ticket = Ticket::findOrFail($ticketid);
        $report = Report::where('ticket_id',$ticket->id)->first();
        return view('admin.tickets.report.edit',compact('ticket','report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $reportid)
    {
        $validated = $request->validate([
            'ticketid' => 'required',
            'machine_model' => 'required',
            'machine_serialno' => 'required',
            'name' => 'required',
            'invoice_number' => 'sometimes',
            'invoice_date' => 'sometimes',
            'purchase_order_number' => 'sometimes',
            'purchase_order_date' => 'sometimes',
            'service_mode' => 'sometimes',
            'asset_number' => 'sometimes',
            'installation_date' => 'required',
            'location' => 'sometimes',
            'warranty' => 'sometimes',
            'amc' => 'sometimes',
            'installation_note' => 'sometimes',
            'spare_parts' => 'sometimes',
            'customer_notes' => 'sometimes',
            'eng1name' => 'sometimes',
            'eng1phone' => 'sometimes',
            'eng1sign' => 'sometimes',
            'cust1name' => 'sometimes',
            'cust1phone' => 'sometimes',
            'cust1sign' => 'sometimes',
        ]);

        $report = Report::where('id',$reportid)->first();

        $reportNum = explode('/', $report->report_number);
        if(count($reportNum) === 4) {
            list($rep_type, $rep_num, $rep_ver, $rep_date) = $reportNum;

            preg_match('/R\.(\d+)/', $rep_ver, $matches);
            $version = $matches[1] ?? null;
            if ($version !== null) {
                $version++;
                // Construct the updated report number
                $updatedrep_ver = "R.$version";
                $updatedReportNumber = $rep_type.'/'.$rep_num.'/'.$updatedrep_ver.'/'.$rep_date;
            }
        }
        
        $warrantyPeriod = null;
        $extendedWarrantyDate = null;
        if($request->warranty==1){
            $warrantyDate = Carbon::createFromFormat('Y-m-d', $request->installation_date);
            $extendedWarrantyDate = $warrantyDate->addMonths(12);
        }else{
            $extendedWarrantyDate = null;
        }

        $result = $report->update([
            'report_number' => $updatedReportNumber,
            'machine_model' => $request->machine_model,
            'machine_serialno' => $request->machine_serialno,
            'cust_name' => $request->name,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'purchase_order' => $request->purchase_order_number,
            'purchase_order_date' => $request->purchase_order_date,
            'service_mode' => $request->service_mode,
            'asset_number' => $request->asset_number,
            'installation_date' => $request->installation_date,
            'location' => $request->location,
            'under_warranty' => $request->warranty,
            'warranty_period' => $extendedWarrantyDate,
            'amc_required' => $request->amc,
            'installation_notes' => $request->installation_note,
            'spare_parts' => $request->spare_parts,
            'customer_notes' => $request->customer_notes,
        ]);

        if($result){
            toastr()->success('Report Updated');
            return to_route('admin.tickets.show',$report->ticket_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
