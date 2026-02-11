<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeAccountActivation extends Notification
{
    use Queueable;

    public $activationUrl;
    public $employeeId;

    public function __construct($activationUrl, $employeeId)
    {
        $this->activationUrl = $activationUrl;
        $this->employeeId = $employeeId;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Activate Your HRIS Account')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your employee account has been created successfully.')
            ->line('Employee ID: ' . $this->employeeId)
            ->line('Please click the button below to activate your account and set your password.')
            ->action('Activate Account', $this->activationUrl)
            ->line('This activation link will expire in 48 hours.')
            ->line('If you did not expect this email, please contact HR department.');
    }
}
