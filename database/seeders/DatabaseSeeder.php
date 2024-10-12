<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Service::create([
            'name' => 'lavado',
            'description' => 'Descripción del servicio de lavado',
            'unit_price' => 10,
        ]);
        Service::create([
            'name' => 'planchado',
            'description' => 'Descripción del servicio de planchado',
            'unit_price' => 20,
        ]);
        Service::create([
            'name' => 'secado',
            'description' => 'Descripción del servicio de secado',
            'unit_price' => 30,
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'password',
        ]);
    }
}
