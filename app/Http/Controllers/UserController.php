<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\UserResource;
use App\Models\Listing;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return inertia(
            'User/Show',
            [
                'user' => UserResource::make($user),
                'reviews' => ReviewResource::collection(Review::where('user_id', $user->id)
                    ->latest('created_at')
                    ->get()),
                'numberOfTrades' => Listing::where('user_id', $user->id)
                    ->whereNotNull('traded_at')
                    ->count(),
                'listings' => ListingResource::collection(Listing::where('user_id', $user->id)
                    ->withoutHidden()
                    ->get())
            ]
        );
    }
}
