<?php

namespace App\Http\Controllers;

use App\Models\Offer;

class UserListingAcceptOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);

        $offer->update(['accepted_at' => now()]);

        $listing->traded_at = now();
        $listing->save();

        $listing->offers()
            ->where('id', '!=', $offer->id)
            ->update(['rejected_at' => now()]);

        //rejects other offers made by offered item
        Offer::where('offer_item_id', $offer->offer_item_id)
            ->where('id', '!=', $offer->id)
            ->whereNull('accepted_at')
            ->whereNull('rejected_at')
            ->update(['rejected_at' => now()]);

        //rejects offers made using this listing
        Offer::where('offer_item_id', $offer->listing_id)
            ->where('id', '!=', $offer->id)
            ->whereNull('accepted_at')
            ->whereNull('rejected_at')
            ->update(['rejected_at' => now()]);

        return redirect()->back()
            ->with('success', 'Oferta została przyjęta, pozostałe zostały odrzucone');
    }
}
