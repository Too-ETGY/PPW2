<?php

namespace App\Jobs;

use App\Mail\ApplicationStatusUpdatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Application;

class SendStatusUpdateMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $application;

    public function __construct($applicationId)
    {
        $this->application = Application::with('job', 'user')
            ->findOrFail($applicationId);
    }

    public function handle(): void
    {
        Mail::to($this->application->user->email)
            ->send(new ApplicationStatusUpdatedMail($this->application));
    }
}
