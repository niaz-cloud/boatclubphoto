<?php

namespace App\Listeners;

use App\Events\ResultPublished;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResultPublishedMail;

class SendResultNotification
{
    public function handle(ResultPublished $event)
    {
        $student = $event->result->student;

        if ($student->user && $student->user->email) {

            Mail::to($student->user->email)
                ->send(new ResultPublishedMail($student));
        }
    }
}
