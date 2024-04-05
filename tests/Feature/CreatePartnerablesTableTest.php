<?php

namespace Tests\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreatePartnerablesTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /* public function it_creates_partnerables_table(): void
    {
        // Vérifie que la table 'partnerables' n'existe pas avant la migration
        $this->assertFalse(Schema::hasTable('partnerables'));

        // Exécute la migration
        $this->artisan('migrate', ['--path' => 'database/migrations']);

        // Vérifie que la table 'partnerables' existe après la migration
        $this->assertTrue(Schema::hasTable('partnerables'));
    } */

    /** @test */
    /* public function it_has_expected_columns(): void
    {
        // Exécute la migration
        $this->artisan('migrate', ['--path' => 'database/migrations']);

        // Vérifie les colonnes de la table 'partnerables'
        $columns = Schema::getColumnListing('partnerables');

        $expectedColumns = [
            'id', 'partner_id', 'partnerable_type', 'partnerable_id', 'actif', 'status', 'can_be_delete',
            'created_at', 'updated_at', 'deleted_at'
        ];

        foreach ($expectedColumns as $column) {
            $this->assertTrue(in_array($column, $columns));
        }
    } */

    /** @test */
    /* public function it_has_foreign_key_to_partners_table(): void
    {
        // Exécute la migration
        $this->artisan('migrate', ['--path' => 'database/migrations']);

        // Vérifie la présence de la clé étrangère 'partner_id'
        $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('partnerables');

        $this->assertNotEmpty($foreignKeys);
        $this->assertTrue(collect($foreignKeys)->contains('partner_id'));
    } */
}
