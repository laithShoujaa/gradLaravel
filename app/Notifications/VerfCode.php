<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Monolog\Formatter\HtmlFormatter;
use Symfony\Component\Mime\Test\Constraint\EmailHtmlBodyContains;

class VerfCode extends Notification
{
    use Queueable;

    private $verfCode;
    private $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($email,$verfCode)
    {
        $this->email=$email;
        $this->verfCode=$verfCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Veification Code!!')
                    ->greeting('Hello!')
                    ->line('Your veryfication code is')
                    ->line(new HtmlString('<h1>'.$this->verfCode.'</h1>'))
                    ->line('Thank you for using our application!');
                    // ->action('Notification Action', url('/'))
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            $this->verfCode,$this->email
        ];
    }
}
