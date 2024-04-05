<?php

namespace Tests\Feature;

use App\Models\UniteMesure;
use App\Models\UniteTravaille;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class UniteTravailleTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();

    // Seed the database
    $this->seed(DatabaseSeeder::class);
  }

  private function create_unite_travaille()
  {
    //get the first UniteMesure
    $unite_mesure = UniteMesure::first();

    // Data to create a worked unit
    $data = [
      'unite_mesure_id' => $unite_mesure->id,
      'type_of_unite_travaille' => 'temps',
      'taux' => [
        [
          'rate' => 180000,
          'hint' => 1,
          'unite_mesure_id' => $unite_mesure->id
        ]
      ]
    ];

    // Send POST request to create a worked unit
    $response = $this->post('/api/unite_travailles', $data);
    // Extracting the JSON data from the response
    $jsonData = $response->json();

    // Accessing the ID of the created worked unit
    $workedUnitId = $jsonData['data']['id'];
    return $response;
  }

  /**
   * Test fetching all unite_travailles.
   * @test 
   * 
   */
  public function test_get_all_unite_travailles()
  {
    // Envoyer une requête GET pour récupérer toutes les unités travaillées
    $response = $this->get('/api/unite_travailles');

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
            'type_of_unite_travaille',
            'created_at',
            'unite_mesure_symbol',
            'taux' => [
              '*' => [
                'id',
                'hint',
                'created_at',
                'rate',
                'rate_measure_unit_symbol',
                'work_unit' => [
                  'type',
                  'symbol',
                ]
              ]
            ]
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
   * Test creating a unite_travaillee.
   * @test 
   * 
   */
  public function test_create_unite_travaillee()
  {
    //create the unite travaille
    $response = $this->create_unite_travaille();

    // Assert HTTP status code 201
    $response->assertStatus(201);

    // Assert the response format
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'type_of_unite_travaille',
        'created_at',
        'unite_mesure_symbol',
        'taux' => [
          '*' => [
            'id',
            'hint',
            'created_at',
            'rate',
            'rate_measure_unit_symbol',
            'work_unit' => [
              'type',
              'symbol',
            ]
          ]
        ]
      ],
      'status_code',
    ]);
    

  }


  /**
   * Test fetching one unite_travaille by ID.
   * @test 
   * 
   */
  public function test_get_one_unite_travaille()
  {
    $response = $this->create_unite_travaille();

    $jsonData = $response->json();

    // Accessing the ID of the created worked unit
    $workedUnitId = $jsonData['data']['id'];
   

    // Envoyer une requête GET pour récupérer une seule unité travaillée
    $response = $this->get("/api/unite_travailles/{$workedUnitId}");

    // Assurer que le code de statut HTTP est 200
    $response->assertStatus(200);

    // Vérifier la structure de la réponse
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'type_of_unite_travaille',
        'created_at',
        'unite_mesure_symbol',
        'taux' => [
          '*' => [
            'id',
            'hint',
            'created_at',
            'rate',
            'rate_measure_unit_symbol',
            'work_unit' => [
              'type',
              'symbol',
            ]
          ]
        ]
      ],
      'status_code',
    ]);
  }

  private function get_unite_travaille()
  {
    $response = $this->create_unite_travaille();

    $jsonData = $response->json();

    // Accessing the ID of the created worked unit
    $workedUnitId = $jsonData['data']['id'];

    // Envoyer une requête GET pour récupérer une seule unité travaillée
    $response = $this->get("/api/unite_travailles/{$workedUnitId}");

    
    //dd($jsonData['data']['id']);
    return $response;
  }

  /**
   * Test updating the first unite_travaille.
   * @test 
   * 
   */
  public function test_update_first_unite_travaille()
  {
    //$this->get_unite_travaille();

    $response = $this->get_unite_travaille();

    $jsonData = $response->json();

    // Accessing the ID of the created worked unit
    $workedUnitId = $jsonData['data']['id'];
    $unite_mesure = UniteMesure::where('symbol',  $jsonData['data']['taux'][0]['rate_measure_unit_symbol'])->first();
    
    // Updating data
    $updatedData = [
      'unite_mesure_id' => $unite_mesure->id,
      'type_of_unite_travaille' => 'temps', // Example update data 
      'taux' => [
        [
          'taux_id' => $jsonData['data']['taux'][0]['id'],
          'hint' => 1,
          'rate' => 1400,
          'unite_mesure_id' => $unite_mesure->id
        ]
      ]
    ];


    // Sending the request
    $response = $this->put("/api/unite_travailles/{$workedUnitId}", $updatedData);

    // Assert HTTP status code 201
    $response->assertStatus(201);

    // Assert response structure
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'type_of_unite_travaille',
        'created_at',
        'unite_mesure_symbol',
        'taux' => [
          '*' => [
            'id',
            'hint',
            'created_at',
            'rate',
            'rate_measure_unit_symbol',
            'work_unit' => [
              'type',
              'symbol',
            ]
          ]
        ]
      ],
      'status_code',
    ]);
  }
}
