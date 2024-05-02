<?php

namespace App\Jobs;

use App\Mail\UserNewCommentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewCommentMailUser implements ShouldQueue
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
            'ticket_id' => $this->details['ticket_id'],
            'user_name' => $this->details['username'],
        ];

        Mail::to($this->details['email'])->send(new UserNewCommentMail($data));
    }
}
