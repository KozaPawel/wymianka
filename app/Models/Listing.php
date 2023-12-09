<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'town_id',
    ];

    protected $sortable = [
        'created_at',
        'updated_at',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

    public function town(): BelongsTo
    {
        return $this->belongsTo(
            Town::class,
            'town_id'
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(
            ListingImage::class
        );
    }

    public function offers(): HasMany
    {
        return $this->hasMany(
            Offer::class,
            'listing_id'
        );
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->latest();
    }

    public function scopeWithoutTraded(Builder $query): Builder
    {
        // return $query->doesntHave('offers')
        //     ->orWhereHas('offers',
        //         fn (Builder $query) => $query
        //             ->whereNull('accepted_at')
        //             ->whereNull('rejected_at'));
        return $query->whereNull('traded_at');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['search'] ?? false,
                fn ($query, $value) => $query->where('name', 'like', "%{$value}%")
            )->when(
                $filters['deleted'] ?? false,
                fn ($query, $value) => $query->withTrashed()
            )->when(
                $filters['by'] ?? $query,
                fn ($query, $value) => ! in_array($value, $this->sortable) ? $query :
                    $query->orderBy($value, $filters['order'] ?? 'desc')
            )->when(
                $filters['categories'] ?? $query,
                fn ($query, $value) => empty($filters['categories']) ? $query :
                $query->whereIn('category_id', $filters['categories'])
            )->when(
                $filters['town'] ?? false,
                fn ($query, $value) => $query->where('town_id', $value)
            );
    }
}

// ->select(
//     'id',
//     'user_id',
//     'name',
//     'description',
//     'city',
// )->groupBy(
//     'id',
//     'user_id',
//     'name',
//     'description',
//     'city',
// )
