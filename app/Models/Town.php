<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Town extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'county',
        'province',
        'lat',
        'lon',
        'search',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(
            Listing::class,
            'town_id'
        );
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['towns'] ?? false,
                fn ($query, $value) => $query->where('search', 'like', "{$value}%")
            );
    }
}
