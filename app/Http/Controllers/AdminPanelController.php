<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Review;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Resources\UserListingResource;
use App\Models\Category;

class AdminPanelController extends Controller
{
    public function listings()
    {
        $listings = Listing::mostRecent()
            ->with('category')
            ->paginate(20)
            ->withQueryString();

        return inertia('AdminPanel/Listing/Index', [
            'listings' => UserListingResource::collection($listings)
        ]);
    }

    public function reviews()
    {
        return inertia('AdminPanel/Review/Index', [
            'reviews' => Review::mostRecent()
                ->with('madeBy')
                ->paginate(20)
                ->withQueryString()
        ]);
    }

    public function categories()
    {
        $categories = Category::paginate(10);

        return inertia('AdminPanel/Category/Index', [
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    public function towns()
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
