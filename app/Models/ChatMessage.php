<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'chat_room_id',
        'user_id'
    ];

    public function room(): HasOne
    {
        return $this->hasOne(
            ChatRoom::class,
            'id', 'chat_room_id'
        );
    }

    public function sender(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id', 'user_id'
        );
    }
}
