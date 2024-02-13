<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'trade_id',
        'by_user_id',
        'user_id',
        'rating',
        'summary'
    ];

    public function madeBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'by_user_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function trade(): BelongsTo
    {
        return $this->belongsTo(
            Offer::class,
            'trade_id'
        );
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->latest('reviews.created_at');
    }

}
