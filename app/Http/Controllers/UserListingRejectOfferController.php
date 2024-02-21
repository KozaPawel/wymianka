<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Gate;

class UserListingRejectOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        if (! Gate::allows('manage-offer', $offer)) {
            abort(403);
        }

        $listing = $offer->listing;
        $this->authorize('update', $listing);

        $offer->update(['rejected_at' => now()]);

        return redirect()->back()
            ->with('success', 'Oferta została odrzucona');
    }
}
