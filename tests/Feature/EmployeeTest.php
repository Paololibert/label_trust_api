<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Poste;
use App\Models\Role;
use App\Models\UniteMesure;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Factory as Faker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  protected function setUp(): void
  {
    parent::setUp();

    // Seed the database
    $this->seed(DatabaseSeeder::class);
  }


  private function create_employee()
  {
    //create faker
    $faker = Faker::create();
    //get the first role 
    $roleId = Role::first();
    //data for creating department
    $data_dematement = [
      "name" => $faker->name()
    ];

    $response_depart = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->post('/api/departements', $data_dematement);

    $response_depart->assertStatus(201);

    $dematementId = $response_depart->json('data.id');

    $data_poste = [
      "name" => $faker->name(),
      "department_id" => $dematementId
    ];

    $response_poste = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->post('/api/postes', $data_poste);

    $response_poste->assertStatus(201);

    $posteId = $response_poste->json('data.id');

    $data_category_employee = ["name" => $faker->name()];

    $response_category_employee = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->post('/api/categories_de_compte', $data_category_employee);

    $response_category_employee->assertStatus(201);

    $category_employeeId = $response_category_employee->json('data.id');

    //get the first UniteMesure
    $uniteMesureId = UniteMesure::first()->id;

    $employeeData = [
      'user' => [
        'login_channel' => 'email',
        'type_of_account' => 'personal',
        'phone_number' => [
          'country_code' => 229,
          'number' => 54121314 // Génère un numéro de téléphone aléatoire à 8 chiffres
        ],
        'email' => $faker->unique()->safeEmail,
        'role_id' => $roleId->id,
        'user' => [
          'name' => "Joel austin",
          'last_name' => $faker->lastName,
          'first_name' => $faker->firstName,
          'username' => $faker->userName,
          'sex' => $faker->randomElement(['male', 'female']),
          'middle_name' => [$faker->firstName, $faker->lastName, $faker->lastName]
        ]
      ],
      'type_employee' => $faker->randomElement(['regular', 'non_regular']),
      'matricule' => $faker->bankAccountNumber, // Génère un numéro de matricule aléatoire
      'name' => "Libert",
      'data' => [
        'reference' => $faker->bankAccountNumber, // Génère une référence aléatoire
        'type_contract' => $faker->randomElement(['CDI', 'CDD', 'Interim']),
        'duree' => $faker->numberBetween(1, 12), // Durée du contrat en mois
        'date_debut' => $faker->date('d-m-Y', 'now'), // Date de début du contrat
        'renouvelable' => $faker->boolean(), // Contrat renouvelable ou non
        'poste_id' => $posteId, // ID du poste associé à l'employé
        'montant' => $faker->numberBetween(1000, 5000), // Montant du salaire
        'unite_mesures_id' => $uniteMesureId, // ID de l'unité de mesure
        'category_of_employee_id' => $category_employeeId,
        //'category_of_employee_taux_id' => '9b8dfa91-072c-4718-aa7b-a26c02c59697' // ID de la catégorie de taux d'employé
      ]
    ];

    // Envoyer une requête POST pour créer un nouveau partenaire
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->postJson('/api/employees', $employeeData);

    return $response;
  }

  /**
   * Test to retrieve all employees.
   *
   * @return void
   */
  public function test_get_all_employees()
  {
    // Envoyer une requête GET pour récupérer tous les employés
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->get('/api/employees');

    // Assurer que le code de statut HTTP est 200
    $response->assertStatus(200);

    // Vérifier la structure de la réponse JSON
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'current_page',
        'data' => [
          '*' => [
            'id',
            'name',
            'description',
            'created_at',
          ]
        ],
        'first_page_url',
        'from',
        'last_page',
        'last_page_url',
        'links' => [
          '*' => [
            'url',
            'label',
            'active'
          ]
        ],
        'next_page_url',
        'path',
        'per_page',
        'prev_page_url',
        'to',
        'total'
      ],
      'status_code'
    ]);
  }

  /**
   * Test to create a new employee.
   *
   * @return void
   */
  public function test_create_employee()
  {
    $response = $this->create_employee();
    // Assurer que le code de statut HTTP est 201 (Créé)
    $response->assertStatus(201);

    // Vérifier la structure de la réponse JSON
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'name',
        'description',
        'created_at',
      ],
      'status_code',
    ]);

    // Vérifier si le partenaire a été créé dans la base de données
    $response->assertJson([
      'status' => true,
      'message' => 'Record created successfully',
      'status_code' => 201,
    ]);

  }

  /**
   * Test to retrieve a specific employee by its ID.
   *
   * @return void
   */
  public function test_get_specific_employee_by_id()
  {
    $response = $this->create_employee();
    // Assurer que le code de statut HTTP est 201 (Créé)
    $response->assertStatus(201);
    $employeeID = $response->json('data.id');

    // Envoyer une requête GET pour récupérer le partenaire spécifique par son identifiant
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->get('/api/employees/' . $employeeID);

    // Assurer que le code de statut HTTP est 200
    $response->assertStatus(200);

    // Vérifier la structure de la réponse JSON pour un partenaire spécifique
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'name',
        'description',
        'created_at',
      ],
      'status_code',
    ]);
  }
  
}
