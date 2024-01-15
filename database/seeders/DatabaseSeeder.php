<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TownSeeder::class,
            CategorySeeder::class,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test1',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test2',
            'email' => 'test2@example.com',
        ]);

        \App\Models\Listing::factory(20)->create();
    }
}
