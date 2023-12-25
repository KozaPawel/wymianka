<?php

namespace App\Http\Resources;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'trader' => UserResource::make($this->trader),
            'listing_user' => UserResource::make(
                User::find(Listing::find($this->listing_id)->user_id)
            ),
            'data' => ListingResource::make(
                Listing::find($this->offer_listing_id)
            ),
            'listing_id' => $this->listing_id,
            'accepted_at' => $this->accepted_at,
            'rejected_at' => $this->rejected_at,
            'cancelled_at' => $this->cancelled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
