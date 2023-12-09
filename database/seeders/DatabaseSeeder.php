<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test1',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test2',
            'email' => 'test2@example.com',
        ]);

        \App\Models\Category::factory(3)->create();

        \App\Models\Listing::factory(20)->create();
    }
}
