<?php

namespace Tests\Feature\Roles;

use App\Http\Controllers\API\RESTful\V1\Auths\LoginController;
use App\Models\Oauths\OauthClient;
use App\Models\Permission;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Core\Utils\Enums\Users\SexEnum;
use Core\Utils\Exceptions\ApplicationException;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Http\Client\RequestException as HttpTimeoutException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * array<int, string>
     */
    protected $requestData;

    /**
     * @var Credential
     */
    protected $credential;

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

        $this->requestData = [
            "name" => $this->faker->unique()->name,
            "description" => $this->faker->sentence(10),
            "permissions" => Permission::take(4)->get("id")->pluck("id")->toArray()
        ];
    }

    /**
     * Tear down the test environment after each test method runs.
     */
    protected function tearDown(): void
    {
        // Clean up any resources used in the testss

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
     * Test creating new role
     * 
     * @return void
     * 
     * @test
     */
    public function testCreateRole()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", $this->requestData);

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
            "message" => "Role created successfully",
            "data" => [
                "name"          => ucfirst(strtolower($this->requestData["name"])),
                "description"   => $this->requestData["description"]/* ,
                "permissions"   => [
                    "*" => [
                        "id" => 
                    ]
                ] */
            ],
            "status_code" => Response::HTTP_CREATED
        ]);

        // Assert that the role was actually created in the database
        $this->assertDatabaseHas('roles', [
            'name'  => strtolower($this->requestData["name"])
        ]);
    }

    /**
     * Test creating a role with missing data.
     *
     * @return void
     * 
     * @test
     */
    public function testCreateRoleWithMissingData()
    {
        $data = $this->requestData;

        unset($data["name"]);

        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", $data);

        // Assert that the response is successful
        $response->assertUnprocessable();

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
            "message" => "Le nom du rôle est requis.",
            "errors" => [
                // Assert specific validation errors here
                "name" => [
                    "Le nom du rôle est requis."
                ]
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);
    }

    /**
     * Test creating a role with empty request data.
     *
     * @return void
     * 
     * @test
     */
    public function testCreateRoleWithEmptyRequestData()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", []);

        // Assert that the response is successful
        $response->assertUnprocessable();

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
            "message" => "Le nom du rôle est requis. (and 1 more error)",
            "errors" => [
                // Assert specific validation errors here
                "name" => [
                    "Le nom du rôle est requis."
                ],
                "permissions" => [
                    "Au moins une permission est requise pour le rôle."
                ]
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);
    }

    /**
     * Test creating a role with a duplicate name.
     *
     * @return void
     * 
     * @test
     */
    public function testCreateRoleWithDuplicateName()
    {
        $this->testCreateRole();

        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", $this->requestData);

        // Assert that the response is successful
        $response->assertUnprocessable();

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code"
        ])->assertJson([
            'status' => false,
            'message' => "Le nom du rôle est déjà utilisé.",
            'errors' => [
                'name' => ["Le nom du rôle est déjà utilisé."],
            ],
            'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ]);
    }

    /**
     * Test creating a role with a long description.
     *
     * @return void
     * 
     * @test
     */
    public function testCreateRoleWithLongDescription()
    {
        // Generate a long description exceeding the maximum allowed length
        $longDescription = Str::random(256);

        // Attempt to create a role with the long description
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", array_merge($this->requestData, [
            'name' => 'RoleWithLongDescription',
            'description' => $longDescription,
        ]));

        $response->assertUnprocessable();

        // Assert that the response is unprocessable entity
        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code",
        ])->assertJson([
            "status" => false,
            "message" => "La description du rôle ne doit pas depasse 255 chaîne de caractères.",
            "errors" => [
                "description" => ["La description du rôle ne doit pas depasse 255 chaîne de caractères."],
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY,
        ]);
    }

    /**
     * Test creating a role with invalid data format.
     *
     * @return void
     * 
     * @test
     */
    public function testCreateRoleWithInvalidDataFormat()
    {
        // Attempt to create a role with the long description
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", array_merge($this->requestData, [
            'name' => $this->faker->randomDigit() // Invalid data format for name
        ]));

        // Assert that the response is unprocessable entity
        $response->assertUnprocessable();

        $response->assertJsonStructure([
            "status",
            "message",
            "errors",
            "status_code",
        ])->assertJson([
            "status" => false,
            "message" => "Le nom du rôle doit être une chaîne de caractères.",
            "errors" => [
                "name" => ["Le nom du rôle doit être une chaîne de caractères."],
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY,
        ]);
    }

    /**
     * Test creating a role with different user roles.
     *
     * @return void
     * 
     * @test
     */
    /* public function testCreateRoleForDifferentUserRoles()
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
        $response = $this->actingAs($userWithDifferentRole)->postJson('api/roles', $this->requestData);

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
     * Test creating a role with invalid HTTP method.
     *
     * @return void
     * 
     * @test
     */
    public function testCreateRoleWithInvalidMethod()
    {
        // Send a POST request instead of a GET request to retrieve a roles
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->putJson("api/roles", $this->requestData);

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
            "message" => "The http method is not supported.",
            "errors" => null,
            "status_code" => Response::HTTP_METHOD_NOT_ALLOWED
        ]);
    }

    /**
     * Test creating a role unauthenticated.
     *
     * @return void
     * @test
     */
    public function testCreateRoleUnauthenticated()
    {
        // Send a request to list roles with a timeout of 3 seconds
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL")
        ])->postJson("api/roles", $this->requestData);

        $response->assertUnauthorized();

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
    }


    /**
     * Test retrieving a roles with invalid authentication token.
     *
     * @return void
     * @test
     */
    public function testCreateRoleWithInvalidAuthenticationToken()
    {
        // Send a request to list roles with a timeout of 3 seconds
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer d" . env("AUTH_BEARER_TOKEN")
        ])->postJson("api/roles", $this->requestData);

        $response->assertUnauthorized();

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
    }

    /**
     * Test creating a role with insufficient roles.
     *
     * @return void
     */
    public function testCreateRoleWithInsufficientPermissions()
    {
        $person = Person::create([

            'name' => "Joel austin",
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'username' => $this->faker->userName,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'middle_name' => [$this->faker->firstName, $this->faker->lastName, $this->faker->lastName]
        ]);

        $user = $person->user()->create([
            'login_channel' => 'email',
            'type_of_account' => 'personal',
            'phone_number' => [
                'country_code' => 229,
                'number' => 90121314 // Génère un numéro de téléphone aléatoire à 8 chiffres
            ],
            'email' => $this->faker->unique()->safeEmail
        ]);

        $credential = $user->credential()->create([
            'created_by' => $user->id,
            'password'  => Hash::make("password"),
            'identifier' => "{$user->{$user->login_channel}}"
        ]);

        $client_data = [
            "id" => Str::orderedUuid(),
            "user_id" => $credential->id,
            "secret" =>   bin2hex(random_bytes(32)),
            "name" => "Password Grant {$user->full_name}",
            "revoked" => 0,
            "password_client" => 1,
            "personal_access_client" => 0,
            "redirect" => config('app.url')
        ];

        OauthClient::create($client_data);

        request()->request->add(['identifier' => $user->credential->identifier, 'password' => "password"]);

        Auth::attempt(['identifier' => $user->credential->identifier, 'password' => "password"]);

        $oauth_client = app(LoginController::class)->authenticateAndIssueToken(request(), $credential);

        // Authenticate the user for the test
        //$this->actingAs($credential);

        // Send a request to list roles
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . $oauth_client->getData()->data->access_token
        ])->actingAs($credential)->postJson("api/roles", $this->requestData);

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
            "message" => "Vous n'avez pas les droits d'accès à cette resource",
            "errors" => null,
            "status_code" => Response::HTTP_FORBIDDEN
        ]);

        // Additional assertions can be added here
    }

    /**
     * Test creating a role with request timeout.
     *
     * @return void
     * @test
     */
    public function testCreateRoleWithRequestTimeout()
    {
        // Mock a request that throws a RequestException to simulate a timeout
        Http::fake([
            '*' => Http::response([
                "status" => false,
                "message" => "Request Timeout",
                "errors" => null,
                "status_code" => Response::HTTP_REQUEST_TIMEOUT
            ], Response::HTTP_REQUEST_TIMEOUT)
        ]);

        try {
            // Send a request to list roles with a timeout of 3 seconds
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->timeout(3)->post("api/roles", $this->requestData);

            // Assert that the response status code is HTTP_REQUEST_TIMEOUT
            $this->assertEquals(Response::HTTP_REQUEST_TIMEOUT, $response->status());

            // Convert the response content to JSON array
            $responseData = $response->json();

            // Assert the JSON structure of the response
            $this->assertArrayHasKey("status", $responseData);
            $this->assertArrayHasKey("message", $responseData);
            $this->assertArrayHasKey("errors", $responseData);
            $this->assertArrayHasKey("status_code", $responseData);

            $this->assertEquals(FALSE, $responseData["status"]);
            $this->assertEquals("Request Timeout", $responseData["message"]);
            $this->assertEquals(NULL, $responseData["errors"]);
            $this->assertEquals(Response::HTTP_REQUEST_TIMEOUT, $responseData["status_code"]);
        } catch (RequestException $exception) {
            // Fail the test if a timeout exception is not thrown
            $this->fail('Expected a timeout exception to be thrown.');
        }
    }


    /**
     * Test creating a role with too many attempts.
     *
     * @return void
     * @test
     */
    public function testCreateRoleWhereTooManyAttempts()
    {
        // Mock a request that returns a HTTP_TOO_MANY_REQUESTS status code
        Http::fake([
            '*' => Http::response([
                "status" => false,
                "message" => "Too Many Requests",
                "errors" => null,
                "status_code" => Response::HTTP_TOO_MANY_REQUESTS
            ], Response::HTTP_TOO_MANY_REQUESTS)
        ]);

        try {
            // Send a request to list roles
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->post("api/roles", $this->requestData);

            // Assert that the response status code is HTTP_TOO_MANY_REQUESTS
            $this->assertEquals(Response::HTTP_TOO_MANY_REQUESTS, $response->status());

            // Convert the response content to JSON array
            $responseData = $response->json();

            // Assert the response structure
            $this->assertArrayHasKey("status", $responseData);
            $this->assertArrayHasKey("message", $responseData);
            $this->assertArrayHasKey("errors", $responseData);
            $this->assertArrayHasKey("status_code", $responseData);
        } catch (RequestException $exception) {
            // Fail the test if an unexpected exception is thrown
            $this->fail('Unexpected exception thrown: ' . $exception->getMessage());
        }
    }

    /**
     * Test creating a role with internal server error.
     *
     * @return void
     * @test
     */
    public function testCreateRoleWithInternalServerError()
    {
        // Mock a request that returns a HTTP_INTERNAL_SERVER_ERROR status code
        Http::fake([
            '*' => Http::response([
                "status" => false,
                "message" => "Internal Server Error",
                "errors" => null,
                "status_code" => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        try {
            // Send a request to list roles
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->post("api/roles", $this->requestData);

            // Assert that the response status code is HTTP_INTERNAL_SERVER_ERROR
            $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->status());

            // Convert the response content to JSON array
            $responseData = $response->json();

            // Assert the response structure
            $this->assertArrayHasKey("status", $responseData);
            $this->assertArrayHasKey("message", $responseData);
            $this->assertArrayHasKey("errors", $responseData);
            $this->assertArrayHasKey("status_code", $responseData);
        } catch (RequestException $exception) {
            // Fail the test if an unexpected exception is thrown
            $this->fail('Unexpected exception thrown: ' . $exception->getMessage());
        }
    }

    /**
     * Test creating a role with service unavailable.
     *
     * @return void
     * @test
     */
    public function testCreateRoleWithServiceUnavailable()
    {
        // Mock a request that returns a HTTP_SERVICE_UNAVAILABLE status code
        Http::fake([
            '*' => Http::response([
                "status" => false,
                "message" => "Service Unavailable",
                "errors" => null,
                "status_code" => Response::HTTP_SERVICE_UNAVAILABLE
            ], Response::HTTP_SERVICE_UNAVAILABLE)
        ]);

        try {
            // Send a request to list roles
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->post("api/roles", $this->requestData);

            // Assert that the response status code is HTTP_SERVICE_UNAVAILABLE
            $this->assertEquals(Response::HTTP_SERVICE_UNAVAILABLE, $response->status());

            // Convert the response content to JSON array
            $responseData = $response->json();

            // Assert the response structure
            $this->assertArrayHasKey("status", $responseData);
            $this->assertArrayHasKey("message", $responseData);
            $this->assertArrayHasKey("errors", $responseData);
            $this->assertArrayHasKey("status_code", $responseData);
        } catch (RequestException $exception) {
            // Fail the test if an unexpected exception is thrown
            $this->fail('Unexpected exception thrown: ' . $exception->getMessage());
        }
    }
}
