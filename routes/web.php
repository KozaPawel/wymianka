<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TownController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\UserListingController;
use App\Http\Controllers\ListingImageController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserListingEndTradeController;
use App\Http\Controllers\UserListingAcceptOfferController;
use App\Http\Controllers\UserListingCancelTradeController;
use App\Http\Controllers\UserListingRejectOfferController;

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

Route::get('/towns', TownController::class)->name('towns');

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
        Route::name('offer.reject')
            ->put('offer/{offer}/reject', UserListingRejectOfferController::class);
        Route::name('trade.cancel')
            ->put('offer/{offer}/cancel', UserListingCancelTradeController::class);
        Route::name('trade.end')
            ->put('offer/{offer}/end', UserListingEndTradeController::class);
        Route::resource('review', ReviewController::class)
            ->only(['store']);
    });

Route::get('user/{user}', [UserController::class, 'show'])
    ->name('user.show');

Route::name('chat.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/chat', [ChatRoomController::class, 'index'])
            ->name('room.index');
        Route::post('/chat/room/show', [ChatRoomController::class, 'show'])
            ->name('room.show');

        Route::get('/chat/room/{roomId}/messages', [ChatMessageController::class, 'index'])
            ->name('message.index');
        Route::post('/chat/room/{roomId}/message', [ChatMessageController::class, 'store'])
            ->name('message.store');
    });
