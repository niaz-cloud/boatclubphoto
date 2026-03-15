<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResultPublishedNotification extends Notification
{
    use Queueable;

    protected $student;

    public function __construct($student)
    {
        $this->student = $student;
    }

    public function via($notifiable)
    {
        return ['database']; // store in database
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Result Published',
            'message' => 'Exam result published for ' . $this->student->name,
            'student_id' => $this->student->id,
        ];
    }
}
