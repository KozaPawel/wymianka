<?php

namespace Database\Seeders;

use App\Models\Town;
use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Town::truncate();

        $csvFile = fopen(base_path('database/data/towns.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            if (! $firstline) {
                Town::create([
                    'name' => $data['0'],
                    'county' => $data['1'],
                    'province' => $data['2'],
                    'lat' => $data['3'],
                    'lon' => $data['4'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
