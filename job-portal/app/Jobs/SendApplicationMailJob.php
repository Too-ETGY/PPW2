<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobAppliedMail;
use App\Models\JobVacancy as Job;

class SendApplicationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job;
    public $user;
    public $appl;

    /**
     * Create a new job instance.
     */
    public function __construct($jobId, $user, $cvPath)
    {
        $this->job = Job::find($jobId);
        $this->user = $user;
        $this->appl = $cvPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new JobAppliedMail($this->job,$this->user, $this->appl));
    }
}
