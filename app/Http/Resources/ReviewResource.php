<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'summary' => $this->whenNotNull($this->summary),
            'made_by' => UserResource::make(User::find($this->by_user_id)),
        ];
    }
}
