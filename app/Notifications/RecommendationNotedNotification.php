<?php

namespace App\Notifications;

use App\Models\FinalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecommendationNotedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private FinalReport $report)
    {
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
            ->greeting('Hello!', $notifiable->name)
            ->line('We hope this email finds you well.')
            ->line('The final report: ' . $this->report->audit_report_title . ', recommendation: ' . $this->report->audit_recommendations . 'has been noted by the stakeholders.')
            ->action('View Report', route('notes.recom.details', $this->report->id))
            ->line('Thank you for using our tool!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->report->audit_report_title,
            'recommendation' => $this->report->audit_recommendations,
            'id' => $this->report->id,
        ];
    }
}