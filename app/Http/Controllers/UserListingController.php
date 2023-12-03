<?php

namespace App\Http\Controllers;

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

        return inertia(
            'User/Index',
            [
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    ->mostRecent()
                    ->withCount('offers')
                    ->withCount('images')
                    ->paginate(8)
                    ->withQueryString(),
            ]);
    }

    public function show(Listing $listing)
    {
        return inertia(
            'User/Show',
            [
                'listing' => $listing->load('offers', 'offers.trader'),
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', Listing::class);

        return inertia(
            'User/Create',
            [
                'categories' => Category::all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $listing = $request->user()->listings()->create(
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'city' => 'required|string',
                'category_id' => 'required',
            ]),
        );

        // $category = Category::find($request->category);

        // $listing->categories()->associate($category);

        return redirect()->route('user.listing.index')
            ->with('success', 'Stworzono nowe ogłoszenie');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia(
            'User/Edit',
            [
                'listing' => $listing,
            ]
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'city' => 'required|string',
            ]),
        );

        return redirect()->route('user.listing.index')
            ->with('success', 'Zaktualizowano ogłoszenie');
    }
}
