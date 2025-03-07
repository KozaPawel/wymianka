<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'data' => ListingResource::make($this),
            'offers' => OfferResource::collection(
                $this->offers()
                    ->orderBy('accepted_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get()
            ),
        ];
    }
}
