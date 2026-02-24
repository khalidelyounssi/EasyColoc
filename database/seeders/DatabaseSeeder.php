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
    $colocation = \App\Models\Colocation::create([
        'name' => 'Mon Appartement Test',
        'description' => 'Colocation de test pour le développement',
        'status' => 'active'
    ]);

    \App\Models\Category::create([
        'name' => 'Alimentation',
        'colocation_id' => $colocation->id
    ]);

    \App\Models\Category::create([
        'name' => 'Factures',
        'colocation_id' => $colocation->id
    ]);

    \App\Models\Category::create([
        'name' => 'Transport',
        'colocation_id' => $colocation->id
    ]);
}
}
