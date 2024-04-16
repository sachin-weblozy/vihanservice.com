<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TicketPool extends Component
{
    public function render()
    {
        // Retrieve unassigned tickets
        $unassignedTickets = Ticket::doesntHave('technicians')->get();
        return view('livewire.admin.ticket-pool', compact('unassignedTickets'));
    }

    public function assignTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        if($ticket->technician == null){
            if(Auth::user()->hasRole('technician')){
                $techid[] = Auth::id();
                if (isset($techid)) {
                    $ticket->technicians()->sync($techid);
                }else {
                    $ticket->technicians()->sync([]);
                }
            }
        }

        toastr()->success('Ticket Accepted');

        // Refresh the component to reflect the changes
        $this->render();
    }
}
