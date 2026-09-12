<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $citiesByState = [
            'Gujarat' => ['Ahmedabad', 'Rajkot', 'Surat'],
            'Maharashtra' => ['Mumbai', 'Pune'],
        ];

        foreach ($citiesByState as $stateName => $cities) {
            $state = State::query()->where('name', $stateName)->firstOrFail();

            foreach ($cities as $name) {
                City::query()->updateOrCreate([
                    'state_id' => $state->id,
                    'name' => $name,
                ]);
            }
        }
    }
}
