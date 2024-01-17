<?php

namespace App\Notifications;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Offer;
use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferPlaced extends Notification
{
    use Queueable;

    public function __construct(
        private Offer $offer
    ) {
        
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            // 'offer_id' => $this->offer->id,
            'listing' => Listing::find($this->offer->listing_id),
            'offer' => Listing::find($this->offer->offer_listing_id),
            'trader' => UserResource::make(User::find($this->offer->trader_id)),
        ];
    }
}
