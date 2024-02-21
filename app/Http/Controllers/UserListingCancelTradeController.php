<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Support\Facades\Gate;

class UserListingCancelTradeController extends Controller
{
    public function __invoke(Offer $offer)
    {
        if (! Gate::allows('manage-trade', $offer)) {
            abort(403);
        }

        $listing = $offer->listing;
        $offerListing = Listing::find($offer->offer_listing_id);

        if ($listing->traded_at === null && $offerListing->traded_at === null) {
            $listing->is_hidden = false;
            $listing->save();

            $offerListing->is_hidden = false;
            $offerListing->save();

            $offer->update(['accepted_at' => null]);
            $offer->update(['cancelled_at' => now()]);
            $offer->update(['rejected_at' => now()]);

            return redirect()->back()
                ->with('success', 'Wymiana została anulowana');
        } else {
            return redirect()->back()
                ->with('success', 'Nie można anulować, wymiana została zakończona');
        }
    }
}
