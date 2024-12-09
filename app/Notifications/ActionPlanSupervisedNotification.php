<?php

namespace App\Notifications;

use App\Models\ActionPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActionPlanSupervisedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private ActionPlan $actionPlan, private string $status)
    {
        //
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
            ->line('The action plan for the report titled ' . $this->actionPlan->audit_report_title . ' has been supervised and ' . $this->status)
            ->action('View Action Plan', url('/action-plans/' . $this->actionPlan->id . '/details'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->actionPlan->id,
            'report_title' => $this->actionPlan->audit_report_title,
            'status' => $this->status
        ];
    }
}
