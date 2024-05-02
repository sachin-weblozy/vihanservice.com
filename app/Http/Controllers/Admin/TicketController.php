<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendTicketAssignMailUser;
use App\Jobs\SendTicketSolvedMailUser;
use App\Jobs\SendNewTicektMailAdmin;
use App\Jobs\SendNewTicektMailUser;
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

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Ticket Read|Ticket Create|Ticket Edit|Ticket Delete|Ticket Assign', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Ticket Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Ticket Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Ticket Delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Ticket Assign', ['only' => ['assign']]);
        $this->middleware('role_or_permission:Ticket Comment', ['only' => ['showComments','addComment']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->hasRole('technician')){
            $tickets = Ticket::whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->latest()->get();
            
        }else{
            $tickets = Ticket::latest()->get();
        }

        return view('admin.tickets.index',compact('tickets'));
    }

    /**
     * Display a listing of the unsolved resource.
     */
    public function new()
    {
        if(Auth::user()->hasRole('technician')){
            $tickets = Ticket::where([['status', '=', 1]])->whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->latest()->get();
            
        }else{
            $tickets = Ticket::where([['status', '=', 1]])->latest()->get();
        }

        return view('admin.tickets.new',compact('tickets'));
    }

    /**
     * Display a listing of the unsolved resource.
     */
    public function inprogress()
    {
        if(Auth::user()->hasRole('technician')){
            $tickets = Ticket::where([['status', '=', 3]])->whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->latest()->get();
            
        }else{
            $tickets = Ticket::where([['status', '=', 3]])->latest()->get();
        }

        return view('admin.tickets.inprogress',compact('tickets'));
    }

    /**
     * Display a listing of the solved resource.
     */
    public function solved()
    {
        if(Auth::user()->hasRole('technician')){
            $tickets = Ticket::where([['status', '=', 4]])->whereHas('technicians', function($query) {
                $query->where('user_id', Auth::id());
            })->latest()->get();
            
        }else{
            $tickets = Ticket::where([['status', '=', 4]])->latest()->get();
        }

        return view('admin.tickets.solved',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $issueTypes = Issuetype::where('parent_id',null)->get();
        return view('admin.tickets.create',compact('issueTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->type==2){
            $request->validate([
                'machine_model'=>'sometimes',
                'machine_serialno'=>'sometimes',
                'issue_type'=>'sometimes',
                'issue_specifications'=>'sometimes',
                'issue_subspecifications'=>'sometimes',
                'title'=>'sometimes',
                'description' => 'required',
                'name'=>'sometimes',
                'phone'=>'sometimes',
                'company'=>'sometimes',
                'type'=>'required',
                'email'=>'required|email',
                'files'=>'sometimes'
            ]);
        }else{
            $request->validate([
                'machine_model'=>'required',
                'machine_serialno'=>'required',
                'issue_type'=>'required',
                'issue_specifications'=>'sometimes',
                'issue_subspecifications'=>'sometimes',
                'title'=>'sometimes',
                'description' => 'required',
                'name'=>'sometimes',
                'phone'=>'sometimes',
                'company'=>'sometimes',
                'type'=>'required',
                'email'=>'required|email',
                'files'=>'sometimes'
            ]);
        }
        

        $userEmail = $request->email;
        $user = User::where('email',$userEmail)->first();
        if($user==null){
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'company'=>$request->company,
                'password'=> Hash::make('passw0rd'),
            ])->assignRole('user');
        }

        $result = Ticket::create([
            'machine_model'=>$request->machine_model,
            'machine_serial'=>$request->machine_serialno,
            'issue_type_id'=>$request->issue_type,
            'issue_specs_id'=>$request->issue_specifications,
            'issue_subspecs_id'=>$request->issue_subspecifications,
            'title'=>$request->title,
            'user_id'=>$user->id,
            'description'=>$request->description,
            'status'=> '1',
            'type'=> $request->type,
            'inst_start'=> $request->inst_start_date,
            'inst_end'=> $request->inst_end_date,
        ]);

        if($result){
            $files = [];
            if ($request->hasFile('files')) {
                $files = [];
                $filePath = 'uploads/ticket_files/'.$result->id.'/';
    
                foreach($request->file('files') as  $file)
                {
                    $fileName = 'ticket_'.$result->id.'_'.time().rand(1,99).'.'.$file->extension();
                    $file->move($filePath, $fileName);
                }
            }
            if ($request->hasFile('recAudio')) {
                $filePath = 'uploads/ticket_files/'.$result->id.'/';
                $audiofile = $request->file('recAudio');
    
                $fileName = 'ticket_'.$result->id.'_'.time().rand(1,99).'.'.$audiofile->extension();
                $audiofile->move($filePath, $fileName);
            }

            if(Auth::user()->hasRole('technician')){
                $techid[] = Auth::id();

                if (isset($techid)) {
                    $result->technicians()->sync($techid);
                }else {
                    $result->technicians()->sync([]);
                }
                
            }

            $usersemail = [];
            $users =  User::role(['superadmin' , 'admin'])->get()->pluck('email')->toArray();
            foreach($users as $user1){
                array_push($usersemail, $user1);
            }

            $userDetails = [
                'email' => $user->email,
                'ticket_id' => $result->id,
                'user_name' => $user->name,
                'user_phone' => $user->phone,
                'ticket_type' => $result->type,
                'date' => $result->created_at,
            ];
            $adminDetails = [
                'email' => $usersemail,
                'ticket_id' => $result->id,
                'user_name' => $user->name,
                'user_phone' => $user->phone,
                'ticket_type' => $result->type,
                'date' => $result->created_at,
            ];

            dispatch(new SendNewTicektMailAdmin($adminDetails));
            dispatch(new SendNewTicektMailUser($userDetails));

            toastr()->success('New Ticket Created');
            return to_route('admin.tickets.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $files=[];
        $ticket = Ticket::findOrFail($id);
        $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
        if (File::exists(public_path($filePath))) {
            $files = File::allFiles(public_path($filePath));
        }
        $technicians = User::role('technician')->latest()->get();
        return view('admin.tickets.show',compact('ticket','technicians','files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $files=[];
        $ticket = Ticket::findOrFail($id);
        $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
        if (File::exists(public_path($filePath))) {
            $files = File::allFiles(public_path($filePath));
        }
        $issueTypes = Issuetype::where('parent_id',null)->get();
        return view('admin.tickets.edit',compact('ticket','files','issueTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        if($ticket){
            if($ticket->type==2){
                $request->validate([
                    'description' => 'sometimes',
                    'files'=>'sometimes',
                ]);

                $ticket->inst_start = $request->inst_start_date;
                $ticket->inst_end = $request->inst_end_date;
                $ticket->description = $request->description;
            }else{
                $request->validate([
                    'machine_model'=>'required',
                    'machine_serialno'=>'required',
                    'issue_type'=>'required',
                    'issue_specifications'=>'sometimes',
                    'issue_subspecifications'=>'sometimes',
                    'title'=>'sometimes',
                    'description' => 'required',
                    'files'=>'sometimes'
                ]);
                $ticket->machine_model = $request->machine_model;
                $ticket->machine_serial = $request->machine_serialno;
                $ticket->issue_type_id = $request->issue_type;
                $ticket->issue_specs_id = $request->issue_specifications;
                $ticket->issue_subspecs_id = $request->issue_subspecifications;
                $ticket->title = $request->title;
                $ticket->description = $request->description;

            }
            $result = $ticket->save();

            if($result){
                $files = [];
                if ($request->hasFile('files')) {
                    $files = [];
                    $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
        
                    foreach($request->file('files') as  $file)
                    {
                        $fileName = 'ticket_'.$ticket->id.'_'.time().rand(1,99).'.'.$file->extension();
                        $file->move($filePath, $fileName);
                    }
                }
                if ($request->hasFile('recAudio')) {
                    $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
                    $audiofile = $request->file('recAudio');
        
                    $fileName = 'ticket_'.$ticket->id.'_'.time().rand(1,99).'.'.$audiofile->extension();
                    $audiofile->move($filePath, $fileName);
                }
                
                toastr()->success('Ticket Updated');
            }else{
                toastr()->error('An error occured');
            }
        }else{
            toastr()->error('No ticket found!');
        }
        return to_route('admin.tickets.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $result = $ticket->delete();

        if($result){
            toastr()->success('Ticket Deleted');
        }else{
            toastr()->error('An error occured!');
        }
        return to_route('admin.tickets.index');
    }

    /**
     * Assign the specified resource to a user.
     */
    public function assign(Request $request, $ticketid)
    {
        $validated = $request->validate([
            'technicians' => 'sometimes|nullable|array',
        ]);

        $ticket = Ticket::findOrFail($ticketid);

        if (isset($validated['technicians'])) {
            $ticket->technicians()->sync($validated['technicians']);
        }else {
            $ticket->technicians()->sync([]);
        }

        if($ticket->status == 1){
            $ticket->update([
                'status'=>3
            ]);
        }

        $userDetails['email'] = $ticket->user->email;

        dispatch(new SendTicketAssignMailUser($userDetails));

        toastr()->success('Ticket Assigned');
        return redirect()->back();
    }

    public function changeStatus(Request $request, $ticketid)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $ticket = Ticket::findOrFail($ticketid);

        $result = $ticket->update([
            'status'=>$validated['status']
        ]);

        if($ticket->solved_at == null){
            if($validated['status']==4){
                $ticket->update([
                    'solved_at'=>now()
                ]);
            }
        }

        if($result){
            if($validated['status']==4){
                $userDetails = [
                    'email' => $ticket->user->email,
                    'ticket_id' => $ticket->user->id,
                ];
                dispatch(new SendTicketSolvedMailUser($userDetails));
            }

            toastr()->success('Ticket Status Updated');
            return redirect()->back();
        }
    }

    public function fetchSpecs($issuetypeid)
    {
        $specs = Issuetype::where('parent_id', $issuetypeid)->get();
        return response()->json($specs);
    }

    public function fetchSubSpecs($issuespecid)
    {
        $subspecs = Issuetype::where('parent_id', $issuespecid)->get();
        return response()->json($subspecs);
    }

    // comments code 
    public function showComments($ticketid)
    {
        $ticket = Ticket::findOrFail($ticketid);
        return view('admin.tickets.comments',compact('ticket'));
    }
}
