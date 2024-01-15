<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data/categories.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            if (! $firstline) {
                Category::create([
                    'name' => $data['0'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
