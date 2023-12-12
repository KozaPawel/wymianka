<?php

namespace App\Http\Controllers;

use App\Models\Offer;

class UserListingRejectOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);

        $offer->update(['rejected_at' => now()]);

        return redirect()->back()
            ->with('success', 'Oferta została odrzucona');
    }
}
