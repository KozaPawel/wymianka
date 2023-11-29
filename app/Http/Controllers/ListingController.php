<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'categories',
        ]);

        $listings = Listing::with('category')
            ->mostRecent()
            ->filter($filters)
            ->withoutTraded()
            ->paginate(12)
            ->withQueryString();

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'categories' => Category::all(),
                'listings' => $listings,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        // dd($listing->user_id === Auth::user()?->id);
        $listing->load('images');

        $offer = ! Auth::user() ? null :
            $listing->offers()->myOffer()->first();

        $filters = [

            'categories' => $listing->category()->pluck('id'),
        ];

        $userListings = ! Auth::user() ? null :
            Auth::user()
                ->listings()
                ->filter($filters)
                ->get()
                ->load('images');

        // $userListings->load('images');

        // if (Auth::user() ? true : false) {

        // }

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'category' => $listing->category,
                'offer' => $offer,
                'userListings' => $userListings,
            ]
        );
    }
}
