<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeeReminderMail;
use App\Notifications\FeeReminderNotification;

class FeeReminderNotification extends Notification
{
    use Queueable;

    protected $student;

    /**
     * Create a new notification instance.
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Get the notification delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // Store notification in DB for UI
    }

    /**
     * Store notification data in database
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Fee Reminder Sent',
            'message' => 'Fee reminder email sent for student ' . $this->student->name,
            'student_id' => $this->student->id,
        ];
    }

    /**
     * Optional array representation
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Fee Reminder Sent',
            'message' => 'Fee reminder email sent for student ' . $this->student->name,
        ];
    }
}
