<?php

namespace App\Jobs;

use App\Mail\UserNewTicketMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewTicektMailUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     */
    public function __construct($userDetails)
    {
        $this->details = $userDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [
            'email' => $this->details['email'],
            'ticket_id' => $this->details['ticket_id'],
            'user_name' => $this->details['user_name'],
            'user_phone' => $this->details['user_phone'],
            'ticket_type' => $this->details['ticket_type'],
            'date' => $this->details['date'],
        ];

        Mail::to($this->details['email'])->send(new UserNewTicketMail($data));
    }
}
