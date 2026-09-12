<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Ahmedabad', 'Rajkot', 'Surat', 'Vadodara'] as $name) {
            Branch::query()->updateOrCreate(['name' => $name]);
        }
    }
}
