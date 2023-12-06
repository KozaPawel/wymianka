<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->owner->name,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'name' => $this->name,
            'description' => $this->description,
            'city' => $this->city,
            'images' => ListingImageResource::collection($this->images),
            'images_count' => $this->images_count,
            'offers_count' => $this->offers_count,
            'traded_at' => $this->traded_at,
        ];
    }
}
