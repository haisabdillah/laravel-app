<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginAlert extends Notification
{
    public $ipAddress,$location,$dateTime;

    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($ipAddress,$location,$dateTime)
    {
        $this->ipAddress = $ipAddress;
        $this->location = $location;
        $this->dateTime = $dateTime;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'LOGIN_ALERT',
            'title' => 'Security Alert: New Login Detected!',
            'data' =>[
                'ip_address' => $this->ipAddress,
                'location' => $this->location,
                'datetime' => $this->dateTime,
            ],

        ];
    }
}
