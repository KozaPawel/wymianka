<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingOfferResource;
use App\Http\Resources\ListingResource;
use App\Http\Resources\UserListingResource;
use App\Models\Category;
use App\Models\Listing;
use Gate;
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
            ...$request->only(['by', 'order', 'status']),
        ];

        $listings = Auth::user()
            ->listings()
            ->filterUserListings($filters)
            ->mostRecent()
            ->withCount('images')
            ->withCount('offers')
            ->paginate(6)
            ->withQueryString();

        return inertia(
            'User/Index',
            [
                'filters' => $filters,
                'listings' => UserListingResource::collection($listings),
            ]);
    }

    public function show(Listing $listing)
    {
        if (! Gate::allows('show-offers', $listing)) {
            abort(403);
        }

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
            'town_id' => 'Pole miejscowość jest wymagane',
            'description.min' => 'Wymagane jest minimum 50 znaków',
        ];

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string|min:50',
            'category_id' => 'required',
            'town_id' => 'required',
        ], $messages);

        $validatedData['name'] = ucfirst(strtolower($validatedData['name']));

        $request->user()->listings()->create($validatedData);

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
            'description.min' => 'Wymagane jest minimum 50 znaków',
        ];

        $listing->update(
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string|min:50',
                'town_id' => 'required',
            ], $messages),
        );

        return redirect()->route('user.listing.index')
            ->with('success', 'Zaktualizowano ogłoszenie');
    }
}
