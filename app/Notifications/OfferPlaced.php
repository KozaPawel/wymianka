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
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $listing = Listing::find($this->offer->listing_id);

        return (new MailMessage)
                    ->subject('Nowa oferta')
                    ->line("Otrzymano nową ofertę dla {$listing->name}.")
                    ->action(
                        'Zobacz oferty wymiany', 
                        route('user.listing.show', ['listing' => $listing->id])
                    );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'listing' => Listing::find($this->offer->listing_id),
            'offer' => Listing::find($this->offer->offer_listing_id),
            'trader' => UserResource::make(User::find($this->offer->trader_id)),
        ];
    }
}
