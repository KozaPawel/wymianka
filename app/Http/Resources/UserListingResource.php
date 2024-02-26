<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Review;
use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hasAcceptedOffer = $this->id === $this->offers->whereNotNull('accepted_at')->pluck('listing_id')->first();

        $tradeId = $hasAcceptedOffer ?
        $this->whenNotNull(
            $this->offers->whereNotNull('accepted_at')->pluck('id')->first()
        ) :
        $this->whenNotNull(
            $this->offered->whereNotNull('accepted_at')->pluck('id')->first()
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'images_count' => $this->whenNotNull($this->images_count),
            'offers_count' => $this->whenNotNull($this->offers_count),
            'user' => UserResource::make(User::find($this->user_id)),
            'trade_for' => $hasAcceptedOffer ?
                $this->whenNotNull(
                    ListingResource::make(
                        Listing::find($this->offers->whereNotNull('accepted_at')->pluck('offer_listing_id')->first())
                    )
                ) :
                $this->whenNotNull(
                    ListingResource::make(
                        Listing::find($this->offered->whereNotNull('accepted_at')->pluck('listing_id')->first())
                    )
                ),
            'trade_id' => $tradeId,
            'can_mark_as_finished' => $this->id === $this->offers->whereNotNull('accepted_at')->pluck('listing_id')->first(),
            'town' => TownResource::make(Town::find($this->town_id)),
            'timestamps' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'trade_started_at' => $hasAcceptedOffer ?
                    $this->whenNotNull(
                        $this->offers->whereNotNull('accepted_at')->pluck('accepted_at')->first()
                    ) :
                    $this->whenNotNull(
                        $this->offered->whereNotNull('accepted_at')->pluck('accepted_at')->first()
                    ),
                'traded_at' => $this->whenNotNull($this->traded_at),
                'deleted_at' => $this->whenNotNull($this->deleted_at),
            ],
            'userReviewed' => Review::all()->where('by_user_id', $this->owner->id)->where('trade_id', $tradeId)->isNotEmpty(),
            'category' => Category::find($this->category_id),
            'hidden_by_admin' => $this->hidden_by_admin,
        ];
    }
}
