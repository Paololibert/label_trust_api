<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Super Administrateur',
            'slug' => 'super-administrateur',
            'key' => 'super_administrateur',
            'description' => 'Super Administrator Role',
        ]);

        Role::create([
            'name' => 'Administrateur',
            'slug' => 'administrateur',
            'key' => 'administrateur',
            'description' => 'Role',
        ]);

        Role::create([
            'name' => 'Employer',
            'slug' => 'Employer',
            'key' => 'Employer',
            'description' => 'Role',
        ]);

        Role::create([
            'name' => 'Partenaire',
            'slug' => 'partenaire',
            'key' => 'partenaire',
            'description' => 'Role',
        ]);
    }
}
