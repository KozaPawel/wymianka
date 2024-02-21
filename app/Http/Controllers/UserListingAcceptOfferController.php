<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Support\Facades\Gate;

class UserListingAcceptOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        if (! Gate::allows('manage-offer', $offer)) {
            abort(403);
        }

        $listing = $offer->listing;
        $offerListing = Listing::find($offer->offer_listing_id);

        $listing->is_hidden = true;
        $listing->save();

        $offerListing->is_hidden = true;
        $offerListing->save();

        if ($offer->rejected_at === null) {
            $offer->update(['accepted_at' => now()]);

            $listing->offers()
                ->where('id', '!=', $offer->id)
                ->update(['rejected_at' => now()]);

            //rejects other offers made by offered item
            Offer::where('offer_listing_id', $offer->offer_listing_id)
                ->where('id', '!=', $offer->id)
                ->whereNull('accepted_at')
                ->whereNull('rejected_at')
                ->update(['rejected_at' => now()]);

            //rejects offers made using this listing
            Offer::where('offer_listing_id', $offer->listing_id)
                ->where('id', '!=', $offer->id)
                ->whereNull('accepted_at')
                ->whereNull('rejected_at')
                ->update(['rejected_at' => now()]);

            return redirect()->back()
                ->with('success', 'Oferta została przyjęta, pozostałe zostały odrzucone');
        } else {
            return redirect()->back()
                ->with('success', 'Akceptowana oferta nie jest już dostępna');
        }
    }
}
