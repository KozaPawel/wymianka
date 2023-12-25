<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'accepted_at',
        'rejected_at',
        'cancelled_at',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(
            Listing::class,
            'listing_id'
        );
    }

    public function offeredItem(): BelongsTo
    {
        return $this->belongsTo(
            Listing::class,
            'offer_listing_id'
        );
    }

    public function trader(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'trader_id'
        );
    }

    public function scopeMyOffer(Builder $query): Builder
    {
        return $query->where('trader_id', Auth::user()?->id);
    }
}
