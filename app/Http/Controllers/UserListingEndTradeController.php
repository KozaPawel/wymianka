<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Support\Facades\Gate;

class UserListingEndTradeController extends Controller
{
    public function __invoke(Offer $offer)
    {
        if (! Gate::allows('manage-trade', $offer)) {
            abort(403);
        }

        $listing = $offer->listing;
        $offerListing = Listing::find($offer->offer_listing_id);

        if ($offer->rejected_at === null) {
            $listing->traded_at = now();
            $listing->save();

            $offerListing->traded_at = now();
            $offerListing->save();

            return redirect()->back()
                ->with('success', 'Wymiana zakończona');
        } else {
            return redirect()->back()
                ->with('success', 'Nie można zakończyć, wymiana anulowana przez drugą osobę');
        }
    }
}
