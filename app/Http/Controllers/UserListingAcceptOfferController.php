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

        return redirect()->back()
            ->with('success', 'Oferta została przyjęta, pozostałe zostały odrzucone');
    }
}
