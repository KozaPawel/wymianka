<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingOfferResource;
use App\Http\Resources\ListingResource;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order']),
        ];

        $listings = Auth::user()
            ->listings()
            ->filter($filters)
            ->mostRecent()
            ->withCount('images')
            ->withCount('offers')
            ->paginate(6)
            ->withQueryString();

        return inertia(
            'User/Index',
            [
                'filters' => $filters,
                'listings' => ListingResource::collection($listings),
            ]);
    }

    public function show(Listing $listing)
    {
        return inertia(
            'User/Show',
            [
                'listing' => ListingOfferResource::make($listing),
            ]
        );
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Usunięto ogłoszenie');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()
            ->with('success', 'Przywrócono ogłoszenie');
    }

    public function create()
    {
        return inertia(
            'User/Create',
            [
                'categories' => Category::all(),
            ]
        );
    }

    public function store(Request $request)
    {
        $messages = [
            'town_id' => 'Pole miasto jest wymagane',
        ];

        $listing = $request->user()->listings()->create(
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required',
                'town_id' => 'required',
            ], $messages),
        );

        // $category = Category::find($request->category);

        // $listing->categories()->associate($category);

        return redirect()->route('user.listing.index')
            ->with('success', 'Stworzono nowe ogłoszenie');
    }

    public function edit(Listing $listing)
    {
        return inertia(
            'User/Edit',
            [
                'listing' => ListingResource::make($listing),
            ]
        );

    }

    public function update(Request $request, Listing $listing)
    {
        $messages = [
            'town_id' => 'Pole miasto jest wymagane',
        ];

        $listing->update(
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'town_id' => 'required',
            ], $messages),
        );

        return redirect()->route('user.listing.index')
            ->with('success', 'Zaktualizowano ogłoszenie');
    }
}
