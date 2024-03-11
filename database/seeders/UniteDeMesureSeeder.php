<?php

namespace Database\Seeders;

use App\Models\UniteMesure;
use Illuminate\Database\Seeder;

class UniteDeMesureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UniteMesure::create([
            'name' => 'Mois',
            'symbol' => 'm'
        ]);

        UniteMesure::create([
            'name' => 'Jour',
            'symbol' => 'j'
        ]);

        UniteMesure::create([
            'name' => 'Heure',
            'symbol' => 'h'
        ]);
    }
}
