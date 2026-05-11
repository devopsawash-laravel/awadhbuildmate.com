<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminLoginLink extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = route('admin.login', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('🔐 Your Awadh Buildmate Admin Login Link')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You requested a secure login link for the **Awadh Buildmate Admin Panel**.')
            ->line('Click the button below to sign in instantly. This link is valid for **15 minutes** and can only be used **once**.')
            ->action('Sign In to Admin Panel', $loginUrl)
            ->line('---')
            ->line('If you did not request this link, please ignore this email. Your account is safe.')
            ->line('For security: do not share this link with anyone.')
            ->salutation('— Awadh Buildmate Security System');
    }
}