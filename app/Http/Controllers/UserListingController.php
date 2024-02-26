<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingOfferResource;
use App\Http\Resources\ListingResource;
use App\Http\Resources\UserListingResource;
use App\Models\Category;
use App\Models\Listing;
use App\Notifications\HiddenByAdmin;
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
            'User/Listing/Index',
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
            'User/ListingOffers/Show',
            [
                'listing' => ListingOfferResource::make($listing),
            ]
        );
    }

    public function destroy(Request $request, Listing $listing)
    {
        $user = $request->user();

        if ($user->id !== $listing->user_id && $user->is_admin) {
            $listing->owner->notify(
                new HiddenByAdmin($listing)
            );

            $listing->is_hidden = true;
            $listing->hidden_by_admin = true;
            $listing->save();

            return redirect()->back()
                ->with('success', 'Ukryto ogłoszenie');
        } else {
            $listing->deleteOrFail();

            return redirect()->back()
                ->with('success', 'Usunięto ogłoszenie');
        }
    }

    public function restore(Request $request, Listing $listing)
    {
        $user = $request->user();

        if ($user->id !== $listing->user_id && $user->is_admin) {

            $listing->is_hidden = false;
            $listing->hidden_by_admin = false;
            $listing->save();

        } else {
            $listing->restore();
        }

        return redirect()->back()
            ->with('success', 'Przywrócono ogłoszenie');
    }

    public function create()
    {
        return inertia(
            'User/Listing/Create',
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
            'category_id' => 'Pole kategorii jest wymagane',
        ];

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string|min:50',
            'category_id' => 'required',
            'town_id' => 'required',
        ], $messages);

        $validatedData['name'] = ucfirst(strtolower($validatedData['name']));

        $request->user()->listings()->create($validatedData);

        return redirect()->route('user.listing.index')
            ->with('success', 'Stworzono nowe ogłoszenie');
    }

    public function edit(Listing $listing)
    {
        return inertia(
            'User/Listing/Edit',
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

        return $request->user()->id !== $listing->user_id ?
        redirect()->route('admin.listings')->with('success', 'Zaktualizowano ogłoszenie') :
        redirect()->route('user.listing.index')->with('success', 'Zaktualizowano ogłoszenie');
    }
}
