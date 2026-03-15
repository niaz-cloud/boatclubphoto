<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeeReminderMail;
use App\Notifications\FeeReminderNotification;

class SendFeeReminder extends Command
{
    /**
     * Command signature
     */
    protected $signature = 'fees:reminder';

    /**
     * Command description
     */
    protected $description = 'Send fee reminder emails to students with unpaid payments';

    /**
     * Execute the command
     */
    public function handle()
    {
        // Get students with unpaid payments and no reminder sent
        $students = Student::whereHas('payments', function ($query) {
            $query->where('status', 'unpaid')
                ->where('reminder_sent', 0);
        })
            ->with(['user', 'payments'])
            ->get();

        // If no students found
        if ($students->isEmpty()) {
            $this->info('No unpaid students found.');
            return;
        }

        foreach ($students as $student) {

            // Skip if student has no user/email
            if (!$student->user || !$student->user->email) {
                $this->warn("Skipping student {$student->name} (no email found)");
                continue;
            }

            // Send email reminder
            Mail::to($student->user->email)
                ->send(new FeeReminderMail($student));

            // Save notification for UI
            $student->user->notify(new FeeReminderNotification($student));

            $this->info("Reminder sent to: {$student->user->email}");

            // Update reminder status
            foreach ($student->payments->where('status', 'unpaid') as $payment) {
                $payment->update([
                    'reminder_sent' => 1
                ]);
            }
        }

        $this->info('Fee reminders sent successfully.');
    }
}
