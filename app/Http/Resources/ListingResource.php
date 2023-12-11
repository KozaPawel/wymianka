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
            'name' => $this->name,
            'description' => $this->description,
            'images' => ListingImageResource::collection($this->images),
            'images_count' => $this->whenNotNull($this->images_count),
            'offers_count' => $this->whenNotNull($this->offers_count),
            'user' => [
                'id' => $this->user_id,
                'name' => $this->owner->name,
            ],
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name,
            ],
            'town' => [
                'id' => $this->town_id,
                'name' => $this->town->name,
                'county' => $this->town->county,
                'province' => $this->town->province,
            ],
            'timestamps' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'traded_at' => $this->whenNotNull($this->traded_at),
                'deleted_at' => $this->whenNotNull($this->deleted_at),
            ],
        ];
    }
}
