<?php

namespace Database\Seeders;

use App\Models\Magasins\Magasin;
use Illuminate\Database\Seeder;

class MagasinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Magasin::create([
            'name'      => 'Super Mart',
            'address'   => 'Cotonou PK10'
        ]);
    }
}
