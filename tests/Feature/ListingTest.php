<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;

class ListingTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_listing_can_be_created(): void
    {
        $this->post('/user/listing', [
            'category_id' => '1',
            'town_id' => '1',
            'name' => 'Testowe Ogłoszenie',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $this->assertDatabaseHas('listings', ['name' => 'Testowe Ogłoszenie']);

        Listing::where('user_id', $this->user->id)->forceDelete();
    }

    public function test_listing_can_be_updated(): void
    {
        $this->post('/user/listing', [
            'category_id' => '1',
            'town_id' => '1',
            'name' => 'Testowe Ogłoszenie',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $listing = Listing::where('name', 'Testowe Ogłoszenie')->first();

        $this->put("/user/listing/{$listing->id}", [
            'name' => 'Zaktualizowane Ogłoszenie',
            'town_id' => '2',
            'description' => 'New lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $this->assertDatabaseHas('listings', ['name' => 'Zaktualizowane Ogłoszenie']);

        Listing::where('user_id', $this->user->id)->forceDelete();
    }

    public function test_listing_cannot_be_updated_with_incorrect_data(): void
    {
        $this->post('/user/listing', [
            'category_id' => '1',
            'town_id' => '1',
            'name' => 'Testowe Ogłoszenie',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $listing = Listing::where('name', 'Testowe Ogłoszenie')->first();

        $response = $this->put("/user/listing/{$listing->id}", [
            'name' => '',
            'town_id' => '',
            'description' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'town_id', 'description']);

        Listing::where('user_id', $this->user->id)->forceDelete();
    }

    public function test_listing_can_be_soft_deleted(): void
    {
        $this->post('/user/listing', [
            'category_id' => '1',
            'town_id' => '1',
            'name' => 'Testowe Ogłoszenie',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $listing = Listing::where('name', 'Testowe Ogłoszenie')->first();
        
        $this->delete("/user/listing/{$listing->id}");

        $this->assertSoftDeleted('listings', [
            'category_id' => '1',
            'town_id' => '1',
            'name' => 'Testowe Ogłoszenie',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        Listing::where('user_id', $this->user->id)->forceDelete();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->user->delete();
    }
}
