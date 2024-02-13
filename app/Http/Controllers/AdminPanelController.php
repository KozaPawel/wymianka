<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\TownResource;
use App\Models\Review;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Resources\UserListingResource;
use App\Models\Category;
use App\Models\Town;

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
        $towns = Town::orderBy('name')
            ->paginate(50);

        return inertia('AdminPanel/Town/Index', [
            'towns' => TownResource::collection($towns)
        ]);
    }
}
