<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HiddenByAdmin extends Notification
{
    use Queueable;

    public function __construct(
        private Listing $listing
    ) {

    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ukryto przedmiot')
            ->line('Administrator ukrył twój przedmiot.')
            ->action("{$this->listing->name}",
                route('listing.show', ['listing' => $this->listing->id]));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'listing' => $this->listing,
        ];
    }
}
