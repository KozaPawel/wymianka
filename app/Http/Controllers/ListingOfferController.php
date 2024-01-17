<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Notifications\OfferPlaced;
use Illuminate\Http\Request;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        $this->authorize('view', $listing);

        $messages = [
            'offerId' => 'Należy wybrać jeden z przedmiotów do wymiany',
        ];

        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'offerId' => 'required|integer',
                ], $messages)
            )->trader()->associate($request->user())
                ->offeredItem()->associate($request->offerId)
        );

        $listing->owner->notify(
            new OfferPlaced($offer)
        );

        return redirect()->back()
            ->with('success', 'Złożono ofertę');
    }
}
