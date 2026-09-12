<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['India', 'USA'] as $name) {
            Country::query()->updateOrCreate(['name' => $name]);
        }
    }
}
