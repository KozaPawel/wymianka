<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Http\Request;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        $this->authorize('view', $listing);

        $messages = [
            'offerId' => 'Należy wybrać jeden z przedmiotów do wymiany',
        ];

        $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'offerId' => 'required|integer',
                ], $messages)
            )->trader()->associate($request->user())
                ->offeredItem()->associate($request->offerId)
        );

        return redirect()->back()
            ->with('success', 'Złożono ofertę');
    }
}
