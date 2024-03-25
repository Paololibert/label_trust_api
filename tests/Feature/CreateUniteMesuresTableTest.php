<?php

namespace Tests\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
class CreateUniteMesuresTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_unite_mesures_table(): void
    {

        // Exécuter la migration
        $this->artisan('migrate', ['--path' => 'database/migrations']); /**/

        $this->assertTrue(Schema::hasTable('unite_mesures'));
    }

    /** @test */
    public function it_has_expected_columns(): void
    {
        
        $this->assertTrue(Schema::hasTable('unite_mesures'));

        $columns = Schema::getColumnListing('unite_mesures');

        $expectedColumns = [
            'id', 'name', 'symbol', 'status', 'can_be_delete',
            'created_by', 'created_at', 'updated_at', 'deleted_at'
        ];

        foreach ($expectedColumns as $column) {
            $this->assertTrue(in_array($column, $columns));
        }
    }

    
/*     public function it_inssert_data():void
    {
        // Create a user
        $user = factory(\App\Models\UniteMesure::class)->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assert that the user is created
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    } */

    /**
     * Test if the migration can be rolled back.
     *
     * @return void
     */
    public function test_migration_can_be_rolled_back()
    {
        // Roll back the migration for users table only
        $this->artisan('migrate:rollback', ['--path' => 'database/migrations']);

        // Assert that the users table does not exist in the database
        $this->assertFalse(Schema::hasTable('unite_mesures'));
    }
}
