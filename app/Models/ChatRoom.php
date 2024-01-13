<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
    
    public function userOne(): BelongsTo
    {
        return $this->belongsTo(
            User::class, 
            'user_one_id', 'id' 
        );
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(
            User::class, 
            'user_two_id', 'id' 
        );
    }

    public function scopeMyRooms(Builder $query): Builder
    {
        return $query->where('user_one_id', Auth::user()?->id)
            ->orWhere('user_two_id', Auth::user()?->id);
    }
}
