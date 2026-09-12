<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $india = Country::query()->where('name', 'India')->firstOrFail();

        foreach (['Gujarat', 'Maharashtra'] as $name) {
            State::query()->updateOrCreate([
                'country_id' => $india->id,
                'name' => $name,
            ]);
        }
    }
}
