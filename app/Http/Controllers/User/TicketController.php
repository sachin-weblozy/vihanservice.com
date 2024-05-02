<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewTicektMailAdmin;
use App\Jobs\SendNewTicektMailUser;
use App\Mail\AdminNewTicketMail;
use App\Models\Issuetype;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Ticket Read|Ticket Create|Ticket Edit|Ticket Delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Ticket Create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Ticket Edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Ticket Delete', ['only' => ['destroy']]);
    }

    protected function getDefaultGuardName(): string { return 'web'; }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::where([['user_id', '=', Auth::id()]])->latest()->get();

        return view('user.tickets.index',compact('tickets'));
    }

    /**
     * Display a listing of the unsolved resource.
     */
    public function unsolved()
    {
        $tickets = Ticket::where([['user_id', '=', Auth::id()],['status', '!=', 4]])->latest()->get();

        return view('user.tickets.unsolved',compact('tickets'));
    }

    /**
     * Display a listing of the solved resource.
     */
    public function solved()
    {
        $tickets = Ticket::where([['user_id', '=', Auth::id()],['status', '=', 4]])->latest()->get();

        return view('user.tickets.solved',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $issueTypes = Issuetype::where('parent_id',null)->get();
        return view('user.tickets.create',compact('issueTypes'));
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
        
        $result = Ticket::create([
            'machine_model'=>$request->machine_model,
            'machine_serial'=>$request->machine_serialno,
            'issue_type_id'=>$request->issue_type,
            'issue_specs_id'=>$request->issue_specifications,
            'issue_subspecs_id'=>$request->issue_subspecifications,
            'title'=>$request->title,
            'user_id'=>Auth::id(),
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

            $usersemail = [];
            $users =  User::role(['superadmin' , 'admin'])->get()->pluck('email')->toArray();
            foreach($users as $user){
                array_push($usersemail, $user);
            }

            $userDetails = [
                'email' => Auth::user()->email,
                'ticket_id' => $result->id,
                'user_name' => Auth::user()->name,
                'user_phone' => Auth::user()->phone,
                'ticket_type' => $result->type,
                'date' => $result->created_at,
            ];
            $adminDetails = [
                'email' => $usersemail,
                'ticket_id' => $result->id,
                'user_name' => Auth::user()->name,
                'user_phone' => Auth::user()->phone,
                'ticket_type' => $result->type,
                'date' => $result->created_at,
            ];

            dispatch(new SendNewTicektMailAdmin($adminDetails));
            dispatch(new SendNewTicektMailUser($userDetails));

            toastr()->success('New Ticket Created');
            return to_route('user.tickets.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $files=[];
        $ticket = Ticket::where([['user_id', '=', Auth::id()],['id', '=', decrypt($id)]])->first();
        if($ticket){
            $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
            if (File::exists(public_path($filePath))) {
                $files = File::allFiles(public_path($filePath));
            }
            return view('user.tickets.show',compact('ticket','files'));
        }else{
            toastr()->error('Not Found');
            return to_route('user.tickets.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $files=[];
        $ticket = Ticket::where([['user_id', '=', Auth::id()],['id', '=', decrypt($id)]])->first();
        if($ticket){
            $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
            if (File::exists(public_path($filePath))) {
                $files = File::allFiles(public_path($filePath));
            }
            $issueTypes = Issuetype::where('parent_id',null)->get();
            return view('user.tickets.edit',compact('ticket','files','issueTypes'));
        }else{
            toastr()->error('Not Found');
            return to_route('user.tickets.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::where([['user_id', '=', Auth::id()],['id', '=', decrypt($id)]])->first();
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
        return to_route('user.tickets.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::where([['user_id', '=', Auth::id()],['id', '=', decrypt($id)]])->first();
        $result = $ticket->delete();

        if($result){
            toastr()->success('Ticket Deleted');
        }else{
            toastr()->error('An error occured!');
        }
        return to_route('user.tickets.index');
    }

    /**
     * Show the comments.
     */
    public function comments($id)
    {
        $ticket = Ticket::where([['user_id', '=', Auth::id()],['id', '=', decrypt($id)]])->first();
        if($ticket){
            return view('user.tickets.comments',compact('ticket'));
        }else{
            toastr()->error('Not Found');
            return to_route('user.tickets.index');
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
    public function showComments($id)
    {
        $ticket = Ticket::where([['user_id', '=', Auth::id()],['id', '=', decrypt($id)]])->first();
        if($ticket){
            return view('user.tickets.comments',compact('ticket'));
        }else{
            toastr()->error('Not Found');
            return to_route('user.tickets.index');
        }
        
    }
}
