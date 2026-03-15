<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use App\Models\Student;

class FeeReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->subject('Monthly Fee Reminder')
            ->view('emails.fee_reminder')
            ->with([
                'student' => $this->student
            ]);
    }
}
