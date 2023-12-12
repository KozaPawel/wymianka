<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Town;
use App\Models\User;
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
            'user' => UserResource::make(User::find($this->user_id)),
            'category' => CategoryResource::make(Category::find($this->category_id)),
            'town' => TownResource::make(Town::find($this->town_id)),
            'timestamps' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'traded_at' => $this->whenNotNull($this->traded_at),
                'deleted_at' => $this->whenNotNull($this->deleted_at),
            ],
        ];
    }
}
