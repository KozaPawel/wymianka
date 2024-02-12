<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Resources\UserListingResource;

class AdminPanelController extends Controller
{
    function listings()
    {
        $listings = Listing::mostRecent()
            ->with('category')
            ->paginate(20)
            ->withQueryString();

        return inertia('AdminPanel/Listing/Index', [
            'listings' => UserListingResource::collection($listings)
        ]);
    }

    function reviews()
    {
        return inertia('AdminPanel/Review/Index', [
            'reviews' => Review::mostRecent()
                ->with('madeBy')
                ->paginate(20)
                ->withQueryString()
        ]);
    }

    function categories(Request $request)
    {
        $listings = Listing::mostRecent()
            ->with('category')
            ->paginate(20)
            ->withQueryString();

        return inertia('AdminPanel/Index', [
            'listings' => UserListingResource::collection($listings)
        ]);
    }

    function towns(Request $request)
    {
        $listings = Listing::mostRecent()
            ->with('category')
            ->paginate(20)
            ->withQueryString();

        return inertia('AdminPanel/Index', [
            'listings' => UserListingResource::collection($listings)
        ]);
    }
}
