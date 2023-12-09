<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ListingResource;
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

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'categories',
            'town',
        ]);

        $listings = Listing::mostRecent()
            ->filter($filters)
            ->withoutTraded()
            ->paginate(12)
            ->withQueryString();

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'categories' => CategoryResource::collection(Category::all()),
                'listings' => ListingResource::collection($listings),
            ]
        );
    }

    public function show(Listing $listing)
    {
        $offer = ! Auth::user() ? null :
            $listing->offers()->myOffer()->first();

        $filters = [
            'categories' => $listing->category()->pluck('id'),
        ];

        $userListings = ! Auth::user() ? null :
            Auth::user()
                ->listings()
                ->filter($filters)
                ->get();

        return inertia(
            'Listing/Show',
            [
                'listing' => ListingResource::make($listing),
                'category' => CategoryResource::make($listing->category),
                'offer' => $offer,
                'userListings' => $userListings ? ListingResource::collection($userListings) : null,
            ]
        );
    }
}
