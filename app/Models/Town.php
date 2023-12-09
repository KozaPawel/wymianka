<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->latest();
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
