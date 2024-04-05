<?php

namespace Tests\Integration\Migrations;

use App\Models\UniteMesure;
use App\Models\UniteTravaille;
use App\Models\User;
use Core\Utils\Enums\TypeUniteTravailleEnum;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateUniteTravailleTableTest extends TestCase
{
  use RefreshDatabase, WithFaker;


  protected function setUp(): void
  {
    parent::setUp();

    // Seed the database
    $this->seed(DatabaseSeeder::class);
  }

  /**
   * @return uuid id;
   */
  private function get_user_id()
  {

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
  public function it_creates_unite_travailles_table(): void
  {

    // Exécuter la migration
    $this->artisan('migrate', ['--path' => 'database/migrations']); /**/

    $this->assertTrue(Schema::hasTable('unite_travailles'));

    // Migration of UniteMesure
    $this->artisan('migrate', ['--path' => 'database/migrations']); /**/

    $this->assertTrue(Schema::hasTable('unite_mesures'));
  }

  /** @test */
  public function it_has_expected_columns(): void
  {

    $this->assertTrue(Schema::hasTable('unite_travailles'));

    $columns = Schema::getColumnListing('unite_travailles');

    $expectedColumns = [
      'id', 'type_of_unite_travaille', 'unite_mesure_id', 'article_id', 'status', 'can_be_delete',
      'created_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    foreach ($expectedColumns as $column) {
      $this->assertTrue(in_array($column, $columns));
    }
  }


  /** @test */
  public function it_creates_unite_travaille()
  {
    // Créer une nouvelle unité de mesure pour obtenir son ID
    $unite_mesure = UniteMesure::create([
      'name' => 'name j',
      'symbol' => 'SYM',
      'created_by' => $this->get_user_id()
    ]);

    // Assurez-vous que l'unité de mesure a été ajoutée à la base de données
    $this->assertDatabaseHas('unite_mesures', [
      'name' => 'name j',
      'symbol' => strtolower('SYM')
    ]);

    // Créer une nouvelle unité travaillée avec l'ID de l'unité de mesure
    $unite_travaille = UniteTravaille::create([
      'type_of_unite_travaille' => 'temps',
      'unite_mesure_id' => $unite_mesure->id,
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);

    // Assurez-vous que l'unité travaillée a été ajoutée à la base de données
    $this->assertDatabaseHas('unite_travailles', [
      'type_of_unite_travaille' => 'temps',
      'unite_mesure_id' => $unite_mesure->id,
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);
  }


  /** @test */
  public function unite_travaille_can_be_retrieved()
  {
    // Générer des données aléatoires
    $type_of_unite_travaille = TypeUniteTravailleEnum::TEMPS; // Utiliser une valeur prédéfinie pour le type
    $rate = $this->faker->numberBetween(1000, 10000); // Générer un taux aléatoire

    // Créer une unité de mesure fictive pour référence
    $unite_mesure = UniteMesure::factory()->create();

    // Créer une nouvelle unité travaillée avec une unité de mesure valide
    $uniteTravaille = UniteTravaille::create([
      'type_of_unite_travaille' => $type_of_unite_travaille,
      'rate' => $rate,
      'unite_mesure_id' => $unite_mesure->id, // Assurez-vous que unite_mesure_id est défini
    ]);

    // Récupérer l'unité travaillée depuis la base de données
    $retrievedUniteTravaille = UniteTravaille::find($uniteTravaille->id);

    // Vérifier que l'unité travaillée récupérée existe
    $this->assertNotNull($retrievedUniteTravaille);

    // Vérifier que l'unité travaillée récupérée a les attributs corrects
    $this->assertEquals($type_of_unite_travaille, $retrievedUniteTravaille->type_of_unite_travaille);
    $this->assertEquals($rate, $retrievedUniteTravaille->rate);
    $this->assertEquals($unite_mesure->id, $retrievedUniteTravaille->unite_mesure_id); // Vérifiez l'unité de mesure associée
  }
}
