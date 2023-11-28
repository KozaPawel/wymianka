<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingImageController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\UserListingAcceptOfferController;
use App\Http\Controllers\UserListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/listing');
});

Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

Route::resource('listing.offer', ListingOfferController::class)
    ->middleware('auth')
    ->only(['store']);

Route::get('/login', [LoginController::class, 'create'])
    ->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');
Route::delete('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

Route::get('/register', [RegisterController::class, 'index'])
    ->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

Route::prefix('user')
    ->name('user.')
    ->middleware('auth')
    ->group(function () {
        Route::name('listing.restore')
            ->put(
                'listing/{listing}/restore',
                [UserListingController::class, 'restore']
            )->withTrashed();
        Route::resource('listing', UserListingController::class);
        Route::resource('listing.image', ListingImageController::class)
            ->only(['create', 'store', 'destroy']);
        Route::name('offer.accept')
            ->put('offer/{offer}/accept', UserListingAcceptOfferController::class);
    });
