<?php

namespace App\Notifications;

use App\Models\FinalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindReport30DayDueNotification extends Notification
{
    use Queueable;

    protected $report;

    /**
     * Create a new notification instance.
     */
    public function __construct(FinalReport $report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello!')
            ->line("You are responsible for the recommendation '{$this->report->audit_recommendations}' for the audit report '{$this->report->audit_report_title}' which is due in 30 days.")
            ->action('View Report', route('notes.recom.details'),)
            ->line('Thank you for your attention.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'report_title' => $this->report->audit_report_title,
            'recom_count' => $this->report->audit_recommendations->count(),
            'due_date' => $this->report->target_completion_date->format('Y-m-d'),
            'date' => now()->format('Y-m-d'),
        ];
    }
}
