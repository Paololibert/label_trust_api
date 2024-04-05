<?php

namespace Tests\Feature;

use App\Models\UniteMesure;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UniteMesureTest extends TestCase
{
  use RefreshDatabase;

  protected $createdUniteMesureId;

  protected function setUp(): void
  {
    parent::setUp();

    // Seed the database
    $this->seed(DatabaseSeeder::class);
  }


  /**
   * Test fetching all unite_mesures.
   * @test 
   * 
   */
  public function test_get_all_unite_mesures()
  {

    // Send GET request to fetch all unite_mesures
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->get('/api/unite_mesures');

    //dd($response);

    // Assert HTTP status code 200
    $response->assertStatus(200);

    // Assert response structure or data as needed
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'current_page',
        'data' => [
          '*' => [
            'id',
            'name',
            'symbol',
            'created_at'
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


  /** @test */
  public function test_create_unite_mesure()
  {
    // Data to create an unite_mesure
    $data = [
      'name' => 'New j one Test Unite Mesure',
      'symbol' => 'Euro',
    ];

    // Send POST request to create an unite_mesure
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->post('/api/unite_mesures', $data);

    // Assert HTTP status code 201
    //$response->assertStatus(201);

    // Assert the response format
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'name',
        'symbol',
        'created_at',
      ],
      'status_code',
    ]);

    $response->assertStatus(201) // Vérifie que la réponse a un code de statut HTTP 200
    ->assertSee("Record created successfully") // Vérifie que la chaîne 'Product retrieved successfully' est présente dans la réponse HTML
    ->assertJsonFragment([ // Vérifie qu'un fragment JSON est présent dans la réponse JSON
      "status" => true,
      "message" => "Record created successfully",
      "status_code" => 201
    ])
    ->assertJsonFragment([ // Vérifie qu'un fragment JSON avec les détails du produit est présent dans la réponse JSON
      "name" => ucfirst(strtolower($data['name'])),
      "symbol" => strtolower($data['symbol']),
      // Ajoutez d'autres valeurs attendues ici
    ]);

    // Assert that the product was actually created in the database
    $this->assertDatabaseHas('unite_mesures', [
      'name' => strtolower($data["name"]),
      'symbol' =>strtolower($data["symbol"]) 
      // Add other expected values as necessary
    ]);

  }

  /**
   * Test fetching one unite_mesure by ID.
   * @test 
   * 
   */
  public function test_get_one_unite_mesure()
  {

    //get first unite mesure
    $unite_mesure = UniteMesure::first();

    // Send GET request to fetch one unite_mesure
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->get("/api/unite_mesures/{$unite_mesure->id}");

    // Assert HTTP status code 200
    //$response->assertStatus(200);

    // Assert response structure
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'name',
        'symbol',
        'created_at',
      ],
      'status_code',
    ]);


    // Assert the type of data returned in the JSON response
    /* $response->assertJson([
      "status" => true,
      "message" => "Product retrieved successfully",
      "data" => [
        "id"              => $unite_mesure->id,
        "name"            => $unite_mesure->name,
        "symbol"          => $unite_mesure->symbol,
        "created_at"      => $unite_mesure->created_at,
        // Add other expected values as necessary
      ],
      "status_code" => Response::HTTP_OK
    ]); */

    $response->assertStatus(200) // Vérifie que la réponse a un code de statut HTTP 200
      ->assertSee(null) // Vérifie que la chaîne 'Product retrieved successfully' est présente dans la réponse HTML
      ->assertJsonFragment([ // Vérifie qu'un fragment JSON est présent dans la réponse JSON
        "status" => true,
        "message" => null,
        "status_code" => 200
      ])
      ->assertJsonFragment([ // Vérifie qu'un fragment JSON avec les détails du produit est présent dans la réponse JSON
        "id" => $unite_mesure->id,
        "name" => $unite_mesure->name,
        "symbol" => $unite_mesure->symbol,
        // Ajoutez d'autres valeurs attendues ici
      ]);
  }

  /**
   * Test updating the first unite_mesure.
   * @test 
   * 
   */
  public function test_update_first_unite_mesure()
  {
    // get the first objet UniteMesure from the database
    $uniteMesure = UniteMesure::first();

    //updating data
    $updatedData = [
      'name' => 'New Name',
      'symbol' => 'N',
    ];

    // sending the request
    $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->put("/api/unite_mesures/{$uniteMesure->id}", $updatedData);


    // Assert response structure
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'name',
        'symbol',
        'created_at'
      ],
      'status_code',
    ]);

    $response->assertStatus(201) // Vérifie que la réponse a un code de statut HTTP 200
    ->assertSee("Record updated successfully") // Vérifie que la chaîne 'Product retrieved successfully' est présente dans la réponse HTML
    ->assertJsonFragment([ // Vérifie qu'un fragment JSON est présent dans la réponse JSON
      "status" => true,
      "message" => "Record updated successfully",
      "status_code" => 201
    ])
    ->assertJsonFragment([ // Vérifie qu'un fragment JSON avec les détails du produit est présent dans la réponse JSON
      "id"  =>$uniteMesure->id,
      "name" => ucfirst(strtolower($updatedData['name'])),
      "symbol" => strtolower($updatedData['symbol']),
      // Ajoutez d'autres valeurs attendues ici
    ]);

    // Assert that the product was actually created in the database
    $this->assertDatabaseHas('unite_mesures', [
      'name' => strtolower($updatedData["name"]),
      'symbol' =>strtolower($updatedData["symbol"]) 
      // Add other expected values as necessary
    ]);

  }

  /**
   * Test retrieving an existing product.
   *
   * @return void
   */
  /* public function testRetrieveExistingProduct()
    {
        // Send a GET request to retrieve the product
        $response = $this->get("api/products/" . $this->product->id);

        // Assert that the response is successful
        $response->assertStatus(Response::HTTP_OK);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "id",
                "name",
                "price",
                "created_at",
                // Add other expected keys as necessary
            ],
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => true,
            "message" => "Product retrieved successfully",
            "data" => [
                "id"            => $this->product->id,
                "name"          => $this->product->name,
                "price"         => $this->product->price,
                "created_at"    => $this->product->created_at,
                // Add other expected values as necessary
            ],
            "status_code" => Response::HTTP_OK
        ]);
    } */
}
