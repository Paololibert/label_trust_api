<?php

namespace Tests\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreatePartnersTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_partners_table(): void
    {
        $this->assertFalse(Schema::hasTable('partners'));

        // Run the migration
        $this->artisan('migrate', ['--path' => 'database/migrations']);

        $this->assertTrue(Schema::hasTable('partners'));
    }

    /** @test */
    public function it_has_expected_columns(): void
    {
        $this->artisan('migrate', ['--path' => 'database/migrations']);

        $columns = Schema::getColumnListing('partners');

        $expectedColumns = [
            'id', 'country', 'company', 'type_partner', 'status', 'can_be_delete',
            'created_by', 'created_at', 'updated_at', 'deleted_at'
        ];

        foreach ($expectedColumns as $column) {
            $this->assertTrue(in_array($column, $columns));
        }
    }
}
