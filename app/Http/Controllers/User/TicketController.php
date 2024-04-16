<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewTicektMailAdmin;
use App\Jobs\SendNewTicektMailUser;
use App\Mail\AdminNewTicketMail;
use App\Models\Issuetype;
use App\Models\Ticket;
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
        $request->validate([
            'machine_model'=>'required',
            'machine_serialno'=>'required',
            'issue_type'=>'required',
            'issue_specifications'=>'sometimes',
            'issue_subspecifications'=>'sometimes',
            'title'=>'sometimes',
            'description' => 'required',
            'type'=>'required',
            'files'=>'sometimes'
        ]);
        
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
            'status'=> $request->type,
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

            $userDetails = [
                'email' => Auth::user()->email,
                'ticket_id' => $result->id,
            ];
            $adminDetails = [
                'email' => 'sachin10157@weblozy.com',
                'ticket_id' => $result->id,
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
    public function show(string $id)
    {
        $files=[];
        $ticket = Ticket::findOrFail($id);
        $filePath = 'uploads/ticket_files/'.$ticket->id.'/';
        if (File::exists(public_path($filePath))) {
            $files = File::allFiles(public_path($filePath));
        }
        return view('user.tickets.show',compact('ticket','files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $issueTypes = Issuetype::where('parent_id',null)->get();
        $issueSpecs = Issuetype::where('parent_id',$ticket->issue_type_id)->get();
        $issueSubSpecs = Issuetype::where('parent_id',$ticket->issue_specs_id)->get();
        return view('user.tickets.edit',compact('ticket','issueTypes','issueSpecs','issueSubSpecs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'machine_model'=>'required',
            'machine_serialno'=>'required',
            'issue_type'=>'required',
            'issue_specifications'=>'sometimes',
            'issue_subspecifications'=>'sometimes',
            'title'=>'sometimes',
            'description' => 'required',
            'files'=>'sometimes'
        ]);

        $result = $ticket->update($validated);
        if($result){
            toastr()->success('Ticket Update');
            return to_route('user.tickets.index');
        }
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
        return to_route('user.tickets.index');
    }

    /**
     * Show the comments.
     */
    public function comments(Ticket $ticket)
    {
        return view('user.tickets.comments',compact('ticket'));
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
        return view('user.tickets.comments',compact('ticket'));
    }
}
