<?php

namespace App\Http\Resources;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'conversation_with' => $this->user_one_id === Auth::user()?->id ? $this->userTwo->name : $this->userOne->name
        ];
    }
}
