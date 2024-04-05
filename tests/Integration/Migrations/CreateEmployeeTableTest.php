<?php

namespace Tests\Integration\Migrations;

use App\Models\CategoryOfEmployee;
use App\Models\Contract;
use App\Models\Departement;
use App\Models\Employee;
use App\Models\EmployeeContractuel;
use App\Models\EmployeeNonContractuel;
use App\Models\Poste;
use App\Models\UniteMesure;
use App\Models\User;
use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Enums\StatutEmployeeEnum;
use Core\Utils\Enums\TypeContratEnum;
use Core\Utils\Enums\TypeEmployeeEnum;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateEmployeeTableTest extends TestCase
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
    $this->artisan('migrate', ['--path' => 'database/migrations']);

    $this->assertTrue(Schema::hasTable('employees'));

    $this->assertTrue(Schema::hasTable('unite_mesures'));

    $this->assertTrue(Schema::hasTable('employee_contractuels'));

    $this->assertTrue(Schema::hasTable('postes'));

    $this->assertTrue(Schema::hasTable('departements'));

    $this->assertTrue(Schema::hasTable('categories_of_employees'));

    $this->assertTrue(Schema::hasTable('employee_non_contractuels'));

    $this->assertTrue(Schema::hasTable('contracts'));
  }

  /** @test */
  public function it_has_expected_columns(): void
  {

    $columns = Schema::getColumnListing('patners');

    $expectedColumns = [
      'id', 'matricule', 'type_employee', 'statut_employee', 'status', 'can_be_delete',
      'created_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    foreach ($expectedColumns as $column) {
      $this->assertTrue(in_array($column, $columns));
    }
  }


  /** @test */

  public function it_creates_employee()
  {
    // Créer un nouvel employé
    $employee = Employee::create([
      'matricule' => 'EMP123',
      'type_employee'       => TypeEmployeeEnum::DEFAULT,
      'statut_employee'     => StatutEmployeeEnum::DEFAULT,
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);



    $category_employee = CategoryOfEmployee::create([
      "name" => "Journalier",
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);

    $employeeNonContractuel = EmployeeNonContractuel::create([
      "category_of_employee_id" => $category_employee->id,
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);

    $employeeContractuel = EmployeeContractuel::create([
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);

    $departement = Departement::first();

    $poste = Poste::create([
      "name"                        => "Journalier",
      "department_id"               => $departement->id,
      'status'                      => true,
      'can_be_delete'               => true,
      'created_by'                  => $this->get_user_id()
    ]);



    $unite_mesures = UniteMesure::first();

    $contract = Contract::create([
      "reference"                   => "Mon contrat",
      "type_contract"               => TypeContratEnum::DEFAULT,
      "duree"                       => 3,
      "date_debut"                  => now(),
      "contract_status"             => StatutContratEnum::DEFAULT,
      "poste_id"                    => $poste->id,
      "employee_contractuel_id"     => $employeeContractuel->id,
      "unite_mesures_id"            => $unite_mesures->id,
      'status'                      => true,
      'can_be_delete'               => true,
      'created_by'                  => $this->get_user_id()
    ]);
    // Assurez-vous que l'employé a été ajouté à la base de données
    $this->assertDatabaseHas('employees', [
      'matricule' => 'EMP123',
      'type_employee'       => TypeEmployeeEnum::DEFAULT,
      'statut_employee'     => StatutEmployeeEnum::DEFAULT,
      'status' => true,
      'can_be_delete' => true,
      'created_by' => $this->get_user_id()
    ]);
  }
}
