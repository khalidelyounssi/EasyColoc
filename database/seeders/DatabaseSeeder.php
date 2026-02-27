<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $colocation = \App\Models\Colocation::create([
        'name' => 'Mon Appartement Test',
        'description' => 'Colocation de test pour le développement',
        'status' => 'active'
    ]);

   Category::create(['name' => 'Alimentation', 'colocation_id' => null]);
Category::create(['name' => 'Loyer', 'colocation_id' => null]);
Category::create(['name' => 'Eau', 'colocation_id' => null]);
Category::create(['name' => 'Électricité', 'colocation_id' => null]);
Category::create(['name' => 'Gaz', 'colocation_id' => null]);
Category::create(['name' => 'Internet', 'colocation_id' => null]);
Category::create(['name' => 'Transport', 'colocation_id' => null]);
}
}
