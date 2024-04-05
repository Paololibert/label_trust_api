<?php

namespace Tests\Integration\Migrations;

use App\Models\UniteMesure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
class CreateUniteMesuresTableTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  /**
   * @return uuid id;
   */
  private function get_user_id()
  {
    // Seed the database
    $this->artisan('db:seed');

    // Assert that the users table has been created
    $this->assertTrue(Schema::hasTable('users'));

    // Assert that at least one user has been seeded
    $this->assertDatabaseCount('users', 1);

    // Retrieve the seeded user from the database
    $user = User::first();

    // Assert that the user exists and has the seeded attributes
    $this->assertNotNull($user);

    return $user->id;
  }

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

  /** @test */
  public function it_creates_unite_mesure()
  {
    // Créez une nouvelle unité de mesure
    $name = $this->faker->unique()->word; // Utilisez Faker pour générer un nom unique
    $symbol = $this->faker->lexify('???'); // Générez un symbole aléatoire
    
    //create an unity of mesurement
    $unite = UniteMesure::create([
      'name'=>$name,
      'symbol'=>$symbol,
      'created_by'=>$this->get_user_id()
    ]);

    // Assurez-vous que l'unité de mesure a été ajoutée à la base de données
    $this->assertDatabaseHas('unite_mesures', [
        'name' => $name,
        'symbol' => $symbol
    ]);
      
  }

  /** @test */
  public function user_can_be_retrieved()
  {
    $name = $this->faker->unique()->word; // Utilisez Faker pour générer un nom unique
    $symbol = $this->faker->lexify('???'); // Générez un symbole aléatoir

    $unite = UniteMesure::create([
      'name'=>$name,
      'symbol'=>$symbol,
      'created_by'=>$this->get_user_id()
    ]);

    // Retrieve the user from the database
    $retrievedunite = UniteMesure::where('name', $name)->first();

    // Assert that the user exists
    $this->assertNotNull($retrievedunite);

    // Assert that the retrieved user has correct attributes
    $this->assertEquals(strtolower($name) ,strtolower($retrievedunite->name) );
    $this->assertEquals($symbol, $retrievedunite->symbol);
  }

  /** @test */
  /* public function test_unite_mesures_table_has_correct_columns()
  {
      // Retrieve column details from the database schema
      $columns = Schema::getColumnListing('unite_mesures');

      
      $tableDetails = Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails('unite_mesures');
      dd($tableDetails);

      // Define expected column definitions
      $expectedColumns = [
          'id' => 'string',
          'name' => 'string',
          'symbol' => 'string',
          'status' => 'boolean',
          'can_be_delete' => 'boolean',
          'created_by' => 'unsignedBigInteger',
          'created_at' => 'timestamp',
          'updated_at' => 'timestamp',
          'deleted_at' => 'timestamp',
      ];

      // Assert that each column exists and has the correct data type
      foreach ($expectedColumns as $column => $expectedDataType) {
        
        dd([$expectedColumns,$column,$expectedDataType, $columns]);
        $this->assertTrue(isset($columns[$column]));

        $this->assertEquals($expectedDataType, $columns[$column]->getType()->getName());
      }
  } */

  /* foreach ($columns as $key => $value) {
    dd([$expectedColumns,$column,$expectedDataType, $columns]);
  } */

  /** @test */
 /*  public function test_unite_mesures_table_has_correct_default_values()
  {
      // Retrieve column details from the database schema
      $columns = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns('unite_mesures');

      // Define expected default values
      $expectedDefaultValues = [
          'status' => true,
      ];

      // Assert that each column has the correct default value
      foreach ($expectedDefaultValues as $column => $defaultValue) {
          $this->assertEquals($defaultValue, $columns[$column]->getDefault());
      }
  } */

  /** @test */
  /* public function test_unite_mesures_table_has_primary_key()
  {
      $primaryKey = (new UniteMesure())->getKeyName();
      $this->assertEquals('id', $primaryKey);
      //$this->assertTrue(Schema::hasPrimary('unite_mesures', 'id'));
  } */
  

  
  /** @test */
  /* public function test_unite_mesures_table_has_unique_name_constraint()
  {
      $this->assertTrue(Schema::hasUnique('unite_mesures', 'name'));
  } */

  /** @test */
  public function it_rolls_back_unite_mesure_table_migration()
  {
      // Reset the database to ensure a clean state
      $this->artisan('migrate:fresh');

      // Assert that the unite_mesure table exists
      $this->assertTrue(Schema::hasTable('unite_mesures'));

      // Roll back the last migration (which includes dropping the unite_mesure table)
      $this->artisan('migrate:rollback');

      // Assert that the unite_mesure table no longer exists
      $this->assertFalse(Schema::hasTable('unite_mesures'));
  }

}
