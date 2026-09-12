<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Web Development', 'Mobile Development', 'SEO', 'Digital Marketing'] as $name) {
            Service::query()->updateOrCreate(['name' => $name]);
        }
    }
}
