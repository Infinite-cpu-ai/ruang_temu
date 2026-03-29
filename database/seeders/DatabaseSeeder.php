<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->client()->create([
            'name' => 'Klien Demo',
            'email' => 'klien@example.com',
        ]);

        $architect = User::factory()->architect()->create([
            'name' => 'Arsitek Demo',
            'email' => 'arsitek@example.com',
        ]);

        $architect->architectProfile()->create([
            'specialization' => 'Hunian & komersial',
            'project_types' => ['Hunian', 'Komersial'],
            'price_per_m2' => 175000,
            'rating' => 4.8,
            'location' => 'Jakarta',
            'style' => 'Modern',
        ]);
    }
}
