<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindStakeholders30DaySummaryNotification extends Notification
{
    use Queueable;

    protected $totalRecommendations;
    protected $totalReports;
    protected $uniqueClients;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $totalRecommendations, int $totalReports, int $uniqueClients)
    {
        $this->totalRecommendations = $totalRecommendations;
        $this->totalReports = $totalReports;
        $this->uniqueClients = $uniqueClients;
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
            ->line("Summary of reports due in 30 days:")
            ->line("Total Recommendations: {$this->totalRecommendations}")
            ->line("Total Reports: {$this->totalReports}")
            ->line("Number of Clients with pending recommendations: {$this->uniqueClients}")
            ->action('View Reports', route('notes.recom.details'), )
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
            'total_recommendations' => $this->totalRecommendations,
            'total_reports' => $this->totalReports,
            'unique_clients' => $this->uniqueClients,
            'date' => now()->format('Y-m-d'),
        ];
    }
}
