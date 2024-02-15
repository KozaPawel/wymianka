<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;
use App\Models\Listing;

class OfferTest extends TestCase
{
    protected $user1, $user2, $listing1, $listing2;

    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        $this->actingAs($this->user1)
            ->post('/user/listing', [
                'category_id' => '1',
                'town_id' => '1',
                'name' => 'Testowe Ogłoszenie',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        
        $this->actingAs($this->user2)
            ->post('/user/listing', [
                'category_id' => '2',
                'town_id' => '2',
                'name' => 'Ogłoszenie',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);

        $this->listing1 = Listing::where('user_id', $this->user1->id)->first();
        $this->listing2 = Listing::where('user_id', $this->user2->id)->first();
    
    }

    public function test_user_can_create_offer_for_other_user_listing(): void
    {
        $this->actingAs($this->user1)
            ->post("/listing/{$this->listing2->id}/offer", [
                'offerId' => $this->listing1->id
            ]);

        $this->assertDatabaseHas('offers', [
            'listing_id' => $this->listing2->id, 
            'offer_listing_id' => $this->listing1->id,
            'trader_id' => $this->user1->id
        ]);

        Offer::where('listing_id', $this->listing2->id)->delete();
        Listing::where('user_id', $this->user1->id)->forceDelete();
        Listing::where('user_id', $this->user2->id)->forceDelete();
    }

    public function test_user_can_accept_offer_for_his_listing(): void
    {
        $this->actingAs($this->user1)
            ->post("/listing/{$this->listing2->id}/offer", [
                'offerId' => $this->listing1->id
            ]);

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->actingAs($this->user2)
            ->put("/user/offer/{$offer->id}/accept");

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->assertNotNull($offer->accepted_at);
        $this->assertNull($offer->rejected_at);

        Offer::where('listing_id', $this->listing2->id)->delete();
        Listing::where('user_id', $this->user1->id)->forceDelete();
        Listing::where('user_id', $this->user2->id)->forceDelete();
    }

    public function test_user_can_reject_offer_for_his_listing(): void
    {
        $this->actingAs($this->user1)
            ->post("/listing/{$this->listing2->id}/offer", [
                'offerId' => $this->listing1->id
            ]);

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->actingAs($this->user2)
            ->put("/user/offer/{$offer->id}/reject");

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->assertNotNull($offer->rejected_at);
        $this->assertNull($offer->accepted_at);

        Offer::where('listing_id', $this->listing2->id)->delete();
        Listing::where('user_id', $this->user1->id)->forceDelete();
        Listing::where('user_id', $this->user2->id)->forceDelete();
    }

    public function test_user_can_mark_trade_as_ended(): void
    {
        $this->actingAs($this->user1)
            ->post("/listing/{$this->listing2->id}/offer", [
                'offerId' => $this->listing1->id
            ]);

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->actingAs($this->user2)
            ->put("/user/offer/{$offer->id}/accept");

        $this->actingAs($this->user2)
            ->put("/user/offer/{$offer->id}/end");

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $listing = Listing::find($offer->listing_id);

        $this->assertNotNull($offer->accepted_at);
        $this->assertNull($offer->rejected_at);
        $this->assertNotNull($listing->traded_at);

        Offer::where('listing_id', $this->listing2->id)->delete();
        Listing::where('user_id', $this->user1->id)->forceDelete();
        Listing::where('user_id', $this->user2->id)->forceDelete();
    }

    public function test_user_can_cancel_trade(): void
    {
        $this->actingAs($this->user1)
            ->post("/listing/{$this->listing2->id}/offer", [
                'offerId' => $this->listing1->id
            ]);

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->actingAs($this->user2)
            ->put("/user/offer/{$offer->id}/accept");

        $this->actingAs($this->user2)
            ->put("/user/offer/{$offer->id}/cancel");

        $offer = Offer::where('trader_id', $this->user1->id)->first();

        $this->assertNull($offer->accepted_at);
        $this->assertNotNull($offer->rejected_at);
        $this->assertNotNull($offer->cancelled_at);

        Offer::where('listing_id', $this->listing2->id)->delete();
        Listing::where('user_id', $this->user1->id)->forceDelete();
        Listing::where('user_id', $this->user2->id)->forceDelete();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->user1->delete();
        $this->user2->delete();
    }
}
