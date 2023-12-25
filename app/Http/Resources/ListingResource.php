<?php

namespace App\Http\Resources;

use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'images' => ListingImageResource::collection($this->images),
            'user' => UserResource::make(
                User::find($this->user_id)
            ),
            'town' => TownResource::make(
                Town::find($this->town_id)
            ),
            'timestamps' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->whenNotNull($this->deleted_at),
            ],
        ];
    }
}
