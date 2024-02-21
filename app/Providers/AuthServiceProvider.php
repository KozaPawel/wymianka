<?php

namespace App\Providers;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'Illuminate\Notifications\DatabaseNotification' => 'App\Policies\NotificationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('show-offers', function (User $user, Listing $listing) {
            if ($user->is_admin === 1) {
                return true;
            } else {
                return $user->id === $listing->user_id;
            }
        });

        Gate::define('manage-offer', function (User $user, Offer $offer) {
            $listing = Listing::find($offer->listing_id);

            return $user->id === $listing->user_id;
        });

        Gate::define('manage-trade', function (User $user, Offer $offer) {
            $listing = Listing::find($offer->listing_id);
            $offeredListing = Listing::find($offer->offer_listing_id);

            return $user->id === $listing->user_id || $user->id === $offeredListing->user_id;
        });
    }
}
