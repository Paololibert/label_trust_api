<?php

namespace Tests\Feature\Permissions;

use App\Http\Controllers\API\RESTful\V1\Auths\LoginController;
use App\Models\Oauths\OauthClient;
use App\Models\Permission;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Str;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ListPermissionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $permissions;

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

        $this->permissions = Permission::paginate();

        if (!$this->isAuth()) {
            $this->authenticate();
        }
    }

    /**
     * Tear down the test environment after each test method runs.
     */
    protected function tearDown(): void
    {
        $this->permissions = null;

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
     * Test retrieving paginate list of permissions
     * 
     * @return void
     * 
     * @test
     */
    public function testListPermissions()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->getJson("api/permissions");

        // Assert that the response is successful
        $response->assertOk();

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "current_page",
                "data" => [
                    // Structure of each item in the 'data' array
                    "*" => [
                        "id",
                        "name",
                        "slug",
                        "description",
                        "created_at"
                    ]
                ],
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total",
            ],
            "status_code"
        ]);

        // Assert pagination data
        $response->assertJson([
            "status" => true,
            "message" => null,
            "data" => [
                "current_page" => 1,
                "per_page" => 15, // Adjust per_page value if needed
            ],
            "status_code" => Response::HTTP_OK
        ]);
    }

    /**
     * Test retrieving paginate list of permissions with invalid HTTP method.
     *
     * @return void
     * 
     * @test
     */
    public function testListPermissionsWithInvalidMethod()
    {
        // Send a POST request instead of a GET request to retrieve a permissions
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
        ])->put("api/permissions");

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
     * Test retrieving a permissions unauthenticated.
     *
     * @return void
     * @test
     */
    public function testListPermissionsUnauthenticated()
    {
        // Send a request to list permissions with a timeout of 3 seconds
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL")
        ])->getJson("api/permissions");

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
     * Test retrieving a permissions with invalid authentication token.
     *
     * @return void
     * @test
     */
    public function testListPermissionsWithInvalidAuthenticationToken()
    {
        // Send a request to list permissions with a timeout of 3 seconds
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer d" . env("AUTH_BEARER_TOKEN")
        ])->getJson("api/permissions");

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
     * Test retrieving a permissions with insufficient permissions.
     *
     * @return void
     */
    public function testListPermissionsWithInsufficientPermissions()
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

        // Send a request to list permissions
        $response = $this->withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Origin" => env("APP_URL"),
            "Authorization" => "Bearer " . $oauth_client->getData()->data->access_token
        ])->actingAs($credential)->getJson("api/permissions");

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
     * Test retrieving permissions with request timeout.
     *
     * @return void
     * @test
     */
    public function testListPermissionsWithRequestTimeout()
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
            // Send a request to list permissions with a timeout of 3 seconds
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->timeout(3)->get("api/permissions");

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
     * Test retrieving permissions with too many attempts.
     *
     * @return void
     * @test
     */
    public function testListPermissionsWhereTooManyAttempts()
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
            // Send a request to list permissions
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->get("api/permissions");

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
     * Test retrieving permissions with internal server error.
     *
     * @return void
     * @test
     */
    public function testListPermissionsWithInternalServerError()
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
            // Send a request to list permissions
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->get("api/permissions");

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
     * Test retrieving permissions with service unavailable.
     *
     * @return void
     * @test
     */
    public function testListPermissionsServiceUnavailable()
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
            // Send a request to list permissions
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Origin" => env("APP_URL"),
                "Authorization" => "Bearer " . env("AUTH_BEARER_TOKEN")
            ])->get("api/permissions");

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
