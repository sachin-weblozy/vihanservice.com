<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public $comments;
    public $newMessage;
    public $ticket_id;

    public function mount($ticket_id)
    {
        $this->comments = Comment::where('ticket_id',$ticket_id)->get();
        $this->newMessage = null;
        $this->ticket_id = $ticket_id;
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
        }
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
