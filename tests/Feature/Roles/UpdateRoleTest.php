<?php

namespace Tests\Feature\Roles;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var Credential
     */
    protected $credential;

    /**
     * array<int, string>
     */
    protected $requestData;

    /**
     * Set up the test environment before each test method runs.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database
        $this->seed(DatabaseSeeder::class);

        if (!$this->isAuth()) {
            $this->authenticate();
        }

        $this->role = Role::latest()->first();

        $this->requestData = [
            "name" => $this->faker->unique()->name,
            "description" => $this->faker->sentence(10),
            "permissions" => Permission::latest()->take(3)->get("id")->pluck("id")->toArray()
        ];
    }

    /**
     * Tear down the test environment after each test method runs.
     */
    protected function tearDown(): void
    {
        // Clean up any resources used in the testss

        $this->role = null;

        $this->requestData = null;

        $this->credential = null;

        parent::tearDown();
    }


    /**
     * Check token
     * 
     * @return bool
     */
    private function isAuth(): bool
    {
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->getJson("api/user", [
            "identifier" => "$this->credential->identifier",
            "password" => "password"
        ]);

        return $response->getData()->status;
    }

    private function authenticate()
    {

        $this->credential = User::first()->credential;

        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
        ])->postJson("api/login", [
            "identifier" => $this->credential->identifier,
            "password" => "password"
        ]);

        // Set the value of the environment variable for testing
        putenv("AUTH_BEARER_TOKEN=" . $response->getData()->data->access_token);
    }

    /**
     * Test update an existing role.
     *
     * @return void
     * 
     * @test
     */
    public function testUpdateExistingRole()
    {
        $this->role = Role::create($this->requestData);
        
        // Send a POST request to update the role
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->putJson("api/roles/" . $this->role->id, $this->requestData);

        // Assert that the response is successful
        $response->assertCreated();

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "id",
                "name",
                "slug",
                "description",
                "created_at",
                "permissions" => [
                    "*" => [
                        "id",
                        "name",
                        "slug",
                        "description",
                        "created_at"
                    ]
                ]
            ],
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => true,
            "message" => "Role updated successfully",
            "data" => [
                "id"            => $this->role->id,
                "name"          => ucfirst(strtolower($this->requestData["name"])),
                "slug"          => $this->role->slug,
                "created_at"    => $this->role->created_at->format("Y-m-d H:m:s")
            ],
            "status_code" => Response::HTTP_CREATED
        ]);

        // Assert that the role was actually created in the database
        $this->assertDatabaseHas('roles', [
            'name'  => strtolower($this->requestData["name"]),
            'key'   => str_replace(" ", "_", strtolower($this->requestData["name"])),
            'slug'   => str_replace(" ", "-", strtolower($this->requestData["name"]))
        ]);
    }

    /**
     * Test updating a non-existing role.
     *
     * @return void
     */
    public function testUpdateNonExistingRole()
    {
        $uuid = Uuid::uuid4()->toString();

        // Send a put request to update a non-existing role
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $uuid, $this->requestData);

        // Assert that the response is not found
        $response->assertStatus(Response::HTTP_NOT_FOUND);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "Record not found.",
            "errors" => null,
            "status_code" => Response::HTTP_NOT_FOUND
        ]);
    }


    /**
     * Test updating with invalid ID format.
     *
     * @return void
     */
    /* public function testUpdateRoleWithInvalidId()
    {
        $invalidUuid = Uuid::uuid4()->toString();

        // Send a GET request with an invalid product ID format
        $response = $this->putJson("api/roles/{$invalidUuid}4", $this->requestData);

        // Assert that the response is a bad request
        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "Invalid UUID provided.",
            "errors" => null,
            "status_code" => Response::HTTP_BAD_REQUEST
        ]);
    } */

    /**
     * Test updating a role with missing data.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithMissingData()
    {
        $data = $this->requestData;

        unset($data["name"]);

        // Send a POST request to create a role with missing data
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, $data);

        // Assert that the response is unprocessable entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "The name field is required. (and 1 more error)",
            "errors" => [
                // Assert specific validation errors here
                "name" => [
                    "The name field is required."
                ]
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);
    } */

    /**
     * Test updating a role with empty request data.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithEmptyRequestData()
    {
        // Send a POST request with an empty request body
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, []);

        // Assert that the response status is unprocessable entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "The name field is required.",
            "errors" => [
                "name" => ["The name field is required."],
                "description" => ["The description field is required."]
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);
    } */

    /**
     * Test updating a role with a duplicate name.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithDuplicateName()
    {
        new Role($this->requestData);

        // Attempt to create another role with the same name
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("/api/roles" . $this->role->id, array_merge($this->requestData, [
            'description' => 'Another role with the same name',
        ]));

        // Assert that the response is unprocessable entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'status_code',
            ])
            ->assertJson([
                'status' => false,
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name has already been taken.'],
                ],
                'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
    } */

    /**
     * Test updating a role with a long description.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithLongDescription()
    {
        // Generate a long description exceeding the maximum allowed length
        $longDescription = Str::random(256);

        // Attempt to create a role with the long description
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("/api/roles" . $this->role->id, [
            'name' => 'RoleWithLongDescription',
            'description' => $longDescription,
        ]);

        // Assert that the response is unprocessable entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'status_code',
            ])
            ->assertJson([
                'status' => false,
                'message' => 'The description may not be greater than 255 characters.',
                'errors' => [
                    'description' => ['The description may not be greater than 255 characters.'],
                ],
                'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
    } */

    /**
     * Test creating a role with invalid data format.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithInvalidDataFormat()
    {
        // Attempt to create a role with invalid data format
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("/api/roles" . $this->role->id, [
            'name' => ['invalid'], // Invalid data format for name
            'description' => 'Role with invalid data format',
        ]);

        // Assert that the response is unprocessable entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'status_code',
            ])
            ->assertJson([
                'status' => false,
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name must be a string.'],
                ],
                'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
    } */

    /**
     * Test creating a role without authentication.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleUnauthenticate()
    {
        // Disable authentication middleware
        $this->withoutMiddleware();

        // Send a POST request to create a role without authentication
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, $this->requestData);

        // Assert that the response is unauthorized
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "You are unauthenticated.",
            "errors" => null,
            "status_code" => Response::HTTP_UNAUTHORIZED
        ]);
    } */

    /**
     * Test creating a role without authentication.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleUnauthorized()
    {
        // Send a POST request without authentication
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles" . $this->role->id, $this->requestData);

        // Assert that the response status is unauthorized
        $response->assertUnauthorized();

        // Assert that the response is unauthorized
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "You are unauthenticated.",
            "errors" => null,
            "status_code" => Response::HTTP_UNAUTHORIZED
        ]);
    } */

    /**
     * Test creating a role with an invalid authentication token.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithInvalidAuthenticationToken()
    {
        // Simulate an invalid authentication token
        $invalidToken = Str::uuid();

        // Send a POST request with an invalid authentication token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $invalidToken,
            'Accept' => 'application/json',
        ])->putJson("api/roles" . $this->role->id, $this->requestData);

        // Assert that the response status is unauthorized
        $response->assertUnauthorized();

        // Assert that the response is unauthorized
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "You are unauthenticated.",
            "errors" => null,
            "status_code" => Response::HTTP_UNAUTHORIZED
        ]);
    } */

    /**
     * Test creating a role with different user roles.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleForDifferentUserRoles()
    {
        //get the first role 
        $roleId = Role::first("id");

        $userFormData = [
            'login_channel' => 'email',
            'type_of_account' => 'personal',
            'phone_number' => [
                'country_code' => 229,
                'number' => 54121314 // Génère un numéro de téléphone aléatoire à 8 chiffres
            ],
            'email' => $this->faker->unique()->safeEmail,
            'role_id' => $roleId->id,
            'user' => [
                'name' => "Joel austin",
                'last_name' => $this->faker->lastName,
                'first_name' => $this->faker->firstName,
                'username' => $this->faker->userName,
                'sex' => $this->faker->randomElement(SexEnum::all()),
                'middle_name' => [$this->faker->firstName, $this->faker->firstName]
            ]
        ];

        // Assuming we have a user with a different role
        // You need to adjust this according to your application's user roles
        $userWithDifferentRole = User::create($userFormData);

        // Send a POST request with the user with a different role
        $response = $this->actingAs($userWithDifferentRole)->putJson("api/roles" . $this->role->id, $this->requestData);

        // Assert that the response status is forbidden
        $response->assertForbidden();

        // Assert that the response is unauthorized
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "You are not authorize to execute this action.",
            "errors" => null,
            "status_code" => Response::HTTP_FORBIDDEN
        ]);
    } */

    /**
     * Test create a role with insufficient role.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithInsufficientPermissions()
    {
        // Mock the authorization check to always return false
        Gate::shouldReceive('allows')->with('create-role')->andReturn(false);

        // Assuming we have a user with insufficient roles
        $user = User::create([
            'type_of_account' => 'personal',
            'username' => 'john_doe',
            'login_channel' => 'web',
            'phone_number' => '123456789',
            'password' => bcrypt('password'),
            'email' => 'john@example.com',
            'address' => '123 Street, City',
            'userable_type' => 'App\Models\Person', // Adjust as per your application structure
            'userable_id' => Uuid::uuid4()->toString(), // Adjust as per your application structure
        ]);

        // Send a GET request to update the roles as the user with insufficient roles
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->actingAs($user)->putJson("api/roles/" . $this->role->id, $this->requestData);

        // Assert that the response status is forbidden
        $response->assertForbidden();

        // Assert that the response is forbidden
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "You are not authorize to execute this action.",
            "errors" => null,
            "status_code" => Response::HTTP_FORBIDDEN
        ]);
    } */

    /**
     * Test creating a role with invalid HTTP method.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithInvalidMethod()
    {
        // Send a GET request instead of a POST request to create a role
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->getJson("api/roles/" . $this->role->id, $this->requestData);

        // Assert that the response status is "Method Not Allowed"
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "The HTTP method is not supported.",
            "errors" => null,
            "status_code" => Response::HTTP_METHOD_NOT_ALLOWED
        ]);
    } */

    /**
     * Test creating a role with request timeout.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithRequestTimeout()
    {
        // Mocking a request timeout scenario (example)
        // This might require additional setup and mocking
        $this->expectException(HttpTimeoutException::class);

        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, $this->requestData);

        $response->assertStatus(Response::HTTP_REQUEST_TIMEOUT);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "Request timeout occurred.",
            "errors" => null,
            "status_code" => Response::HTTP_REQUEST_TIMEOUT
        ]);
    } */


    /**
     * Test creating a role with too many attempts.
     *
     * @return void
     * 
     * @test
     */
    /* public function testUpdateRoleWithTooManyAttempts()
    {
        // Mocking a scenario where there are too many attempts
        RateLimiter::shouldReceive('hit')->andReturn(false);

        // Send multiple requests to create a role
        for ($i = 0; $i < 11; $i++) {
            $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, $this->requestData);
        }

        // Assert that the response status is HTTP_TOO_MANY_REQUESTS
        $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "Too Many Attempts.",
            "errors" => null,
            "status_code" => Response::HTTP_TOO_MANY_REQUESTS
        ]);
    } */


    /**
     * Test creating a role with internal server error.
     *
     * @return void
     * 
     * @test
     */
    /*public function testUpdateRoleWithInternalServerError()
     {
        // Mocking an internal server error scenario (example)
        // This might require additional setup and mocking
        // For example, you can mock a scenario where an exception occurs during the role creation process

        // Simulate an internal server error by causing an exception
        DB::shouldReceive('beginTransaction')->andThrow(new ApplicationException('Internal server error occurred.'));

        // Send a POST request to create the role
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, $this->requestData);

        // Assert that the response status is HTTP_INTERNAL_SERVER_ERROR
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "Internal server error occurred.",
            "errors" => null,
            "status_code" => Response::HTTP_INTERNAL_SERVER_ERROR
        ]);

        // Additional assertions can be added here
    } */


    /**
     * Test creating a role with service unavailable.
     *
     * @return void
     * 
     * @test
     */
    /*public function testUpdateRoleWithServiceUnavailable()
     {
        // Mock a scenario where the service is unavailable during role creation
        Http::fake(function ($request) {
            return Http::response(['message' => 'Service Unavailable'], Response::HTTP_SERVICE_UNAVAILABLE);
        });

        // Send a POST request to create a role
        $response = $this->withHeaders(["Accept" => "application/json", "Content-Type" => "application/json", "Origin" => env("APP_URL")])->putJson("api/roles/" . $this->role->id, $this->requestData);

        // Assert that the response status is HTTP_SERVICE_UNAVAILABLE
        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ]);

        // Assert the type of data returned in the JSON response
        $response->assertJson([
            "status" => false,
            "message" => "Service Unavailable",
            "errors" => null,
            "status_code" => Response::HTTP_SERVICE_UNAVAILABLE
        ]);
    } */
}