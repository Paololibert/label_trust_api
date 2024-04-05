<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Factory as Faker;
use Tests\TestCase;

class PartnerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  protected function setUp(): void
  {
    parent::setUp();

    // Seed the database
    $this->seed(DatabaseSeeder::class);
  }

  private function create_partner()
  {
    
    $faker = Faker::create();

    $roleId = Role::first();

    // Données simulées pour la création d'un partenaire
    $partnerData = [
      'user' => [
        'login_channel' => 'email',
        'type_of_account' => 'personal', // Remplacer par des valeurs aléatoires appropriées
        'phone_number' => [
          'country_code' => 229,
          'number' => 61670098, // Remplacer par un format de numéro approprié
        ],
        'email' => $faker->unique()->safeEmail,
        'role_id' => $roleId->id, // Remplacer par l'ID du rôle approprié
        'user' => [
          'name' => $faker->company,
          'last_name' => $faker->lastName,
          'first_name' => $faker->firstName,
          'username' => $faker->userName,
          'sex' => $faker->randomElement(['male', 'female']), // Remplacer par des valeurs aléatoires appropriées
          'middle_name' => [$faker->firstName, $faker->lastName, $faker->lastName],
        ],
      ],
      'type_partner' => 'supplier', // Remplacer par le type de partenaire approprié
      'data' => [
        'country' => $faker->country, // Remplacer par un pays aléatoire approprié
        'company' => $faker->company,
      ],
    ];


    // Envoyer une requête POST pour créer un nouveau partenaire
    $response = $this->postJson('/api/partners', $partnerData);
    return $response;
  }

  /**
   * Test to retrieve all partners.
   *
   * @return void
   */
  public function test_get_all_partners()
  {
    // Envoyer une requête GET pour récupérer tous les partenaires
    $response = $this->get('/api/partners');

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
            'country',
            'company',
            'type_partner',
            'created_at',
            'suppliers' => [
              '*' => [
                'id',
                'created_at',
              ]
            ],
            'user' => [
              'id',
              'username',
              'phone_number',
              'address',
              'email',
              'created_at',
              'role_ids',
              'userable' => [
                'id',
                'last_name',
                'first_name',
                'middle_name',
                'sex',
                'created_at',
                'full_name'
              ]
            ],
            'clients' => [
              '*' => [
                'id',
                'created_at',
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
   * Test to create a new partner.
   *
   * @return void
   */
  public function test_create_partner()
  {
    $response = $this->create_partner();
    // Assurer que le code de statut HTTP est 201 (Créé)
    $response->assertStatus(201);
    $partnerId = $response->json('data.id');
 
    // Vérifier la structure de la réponse JSON
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'country',
        'company',
        'type_partner',
        'created_at',
        'suppliers' => [
          '*' => [
            'id',
            'created_at',
          ],
        ],
        'user' => [
          'id',
          'username',
          'phone_number',
          'address',
          'email',
          'created_at',
          'role_ids',
          'userable' => [
            'id',
            'last_name',
            'first_name',
            'middle_name',
            'sex',
            'created_at',
            'full_name',
          ],
        ],
        'clients',
      ],
      'status_code',
    ]);

    /* $response->assertStatus(201) // Vérifie que la réponse a un code de statut HTTP 201
    ->assertSee("Record created successfully") // Vérifie que la chaîne 'Record created successfully' est présente dans la réponse HTML
    ->assertJsonFragment([ // Vérifie qu'un fragment JSON est présent dans la réponse JSON
        "status" => true,
        "message" => "Record created successfully",
        "status_code" => 201
    ])
    ->assertJsonFragment([ // Vérifie qu'un fragment JSON avec les détails du partenaire est présent dans la réponse JSON
        "id" => $response['data']['id'],
        "country" => $response['data']['country'],
        "company" => $response['data']['company'],
        "type_partner" => $response['data']['type_partner'],
        "created_at" => $response['data']['created_at'],
        "suppliers" => $response['data']['suppliers'],
        "user" => [
            "id" => $response['data']['user']['id'],
            "username" => $response['data']['user']['username'],
            "phone_number" => $response['data']['user']['phone_number'],
            "address" => $response['data']['user']['address'],
            "email" => $response['data']['user']['email'],
            "created_at" => $response['data']['user']['created_at'],
            "role_ids" => $response['data']['user']['role_ids'],
            "userable" => [
                "id" => $response['data']['user']['userable']['id'],
                "name" => $response['data']['user']['userable']['name'],
                "registration_number" => $response['data']['user']['userable']['registration_number'],
                "created_at" => $response['data']['user']['userable']['created_at']
            ]
        ],
        "clients" => $response['data']['clients']
    ]); */


    // Vérifier si le partenaire a été créé dans la base de données
    $response->assertJson([
      'status' => true,
      'message' => 'Record created successfully',
      'status_code' => 201,
    ]);
  }

  /**
   * Test to retrieve a specific partner by its ID.
   *
   * @return void
   */
  public function test_get_specific_partner_by_id()
  {
    $response = $this->create_partner();
    // Assurer que le code de statut HTTP est 201 (Créé)
    $response->assertStatus(201);
    $partnerId = $response->json('data.id');
    
    // Envoyer une requête GET pour récupérer le partenaire spécifique par son identifiant
    $response = $this->get('/api/partners/' . $partnerId);

    // Assurer que le code de statut HTTP est 200
    $response->assertStatus(200);

    // Vérifier la structure de la réponse JSON pour un partenaire spécifique
    $response->assertJsonStructure([
      'status',
      'message',
      'data' => [
        'id',
        'country',
        'company',
        'type_partner',
        'created_at',
        'suppliers' => [
          '*' => [
            'id',
            'created_at',
          ]
        ],
        'user' => [
          'id',
          'username',
          'phone_number',
          'address',
          'email',
          'created_at',
          'role_ids',
          'userable' => [
            'id',
            'last_name',
            'first_name',
            'middle_name',
            'sex',
            'created_at',
            'full_name'
          ]
        ],
        'clients' => [
          '*' => [
            'id',
            'created_at',
          ]
        ]
      ],
      'status_code'
    ]);
    
  }

}
