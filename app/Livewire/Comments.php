<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Ticket;
use App\Jobs\SendNewCommentMailUser;
use Livewire\Component;

class Comments extends Component
{
    public $comments;
    public $newMessage;
    public $ticket_id;
    public $ticketdata;
    public $useremail;
    public $username;

    public function mount($ticket_id)
    {
        $this->comments = Comment::where('ticket_id',$ticket_id)->get();
        $this->newMessage = null;
        $this->ticket_id = $ticket_id;
        $userData = Ticket::where('id',$this->ticket_id)->first();
        $this->ticketdata = $userData;
        $this->useremail = $userData->user->email;
        $this->username = $userData->user->name;
    }

    public function sendMessage()
    {
        if($this->newMessage){
            $result = Comment::create([
                'ticket_id' => $this->ticket_id,
                'user_id' => Auth::user()->id,
                'message' => $this->newMessage,
            ]);
            
            $this->newMessage = '';
            $this->comments = Comment::where('ticket_id',$this->ticket_id)->get();
            $this->dispatch('sendMessage');

            $userDetails = [
                'email' => $this->useremail,
                'ticket_id' => $this->ticket_id,
                'username' => $this->username,
            ];

            dispatch(new SendNewCommentMailUser($userDetails));
        }
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
