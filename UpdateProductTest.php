<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Core\Utils\Exceptions\ApplicationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tests\TestCase;
use Illuminate\Http\Client\RequestException as HttpTimeoutException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Product
     */
    protected $product;

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

        $this->requestData = [
            "name" => $this->faker->unique()->name,
            "price" => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1000 with 2 decimal places
        ];

        // Initialize any data or resources needed for tests
        $this->product = Product::create($this->requestData);
    }

    /**
     * Tear down the test environment after each test method runs.
     */
    protected function tearDown(): void
    {
        // Clean up any resources used in the tests
        $this->requestData = null;

        parent::tearDown();
    }

    /**
     * Test updating an existing product.
     *
     * @return void
     */
    public function testUpdateExistingProduct()
    {

        $this->requestData = [
            "name" => $this->faker->unique()->name,
            "price" => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1000 with 2 decimal places
        ];

        // Send a PUT request to update the product
        $response = $this->put("api/products/{$this->product->id}", $this->requestData);

        // Assert that the response is successful
        $response->assertStatus(Response::HTTP_CREATED);

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
            "message" => "Product updated successfully",
            "data" => [
                "id"            => $this->product->id,
                "name"          => $this->requestData["name"],
                "price"         => $this->requestData["price"],
                "created_at"    => $this->product->created_at,
                // Add other expected values as necessary
            ],
            "status_code" => Response::HTTP_OK
        ]);

        // Assert that the product was actually created in the database
        $this->assertDatabaseHas('products', [
            "id"            => $this->product->id,
            'name' => $this->requestData["name"],
            'price' => $this->requestData["price"]
            // Add other expected values as necessary
        ]);
    }

    /**
     * Test updating a non-existing product.
     *
     * @return void
     */
    public function testUpdateNonExistingProduct()
    {
        // Generate a UUID for a non-existing product
        $invalidUuid = Uuid::uuid4()->toString();

        // Send a PUT request to update the non-existing product
        $response = $this->put("api/products/{$invalidUuid}", $this->requestData);

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

        // Additional assertions can be added here
    }

    /**
     * Test creating a product with missing data.
     *
     * @return void
     */
    public function testCreateProductWithMissingData()
    {

        $invalidUuid = Uuid::uuid4()->toString();

        // Send a PUT request to update the non-existing product
        $response = $this->put("api/products/{$invalidUuid}4", $this->requestData);

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
    }

    /**
     * Test updating a product with invalid data.
     *
     * @return void
     */
    public function testUpdateProductWithInvalidData()
    {

        $this->requestData = [
            "name" => $this->faker->unique()->name,
            "price" => $this->faker->randomFloat(2, 10, 1000) . "d", // Random price between 10 and 1000 with 2 decimal places
        ];

        // Send a PUT request to update the product with invalid data
        $response = $this->put("api/products/{$this->product->id}", $this->requestData);

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
            "message" => "The name field is required.",
            "errors" => [
                "name" => ["The name field is required."]
            ],
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);
    }


    /**
     * Test updating a product without authentication.
     *
     * @return void
     */
    public function testUpdateProductWithoutAuthentication()
    {

        // Disable authentication middleware
        $this->withoutMiddleware();

        // Send a PUT request to update the product without authentication
        $response = $this->putJson("api/products/{$this->product->id}", $this->requestData);

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
    }



    /**
     * Test updating a product with insufficient permissions.
     *
     * @return void
     */
    public function testUpdateProductWithInsufficientPermissions()
    {
        // Mock the authorization check to always return false
        Gate::shouldReceive('allows')->with('update-product', $this->product)->andReturn(false);

        // Assuming we have a user with insufficient permissions
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

        // Send a PUT request to update the product as the user with insufficient permissions
        $response = $this->actingAs($user)->putJson("api/products/{$this->product->id}", $this->requestData);

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
            "message" => "You are not authorized to execute this action.",
            "errors" => null,
            "status_code" => Response::HTTP_FORBIDDEN
        ]);
    }

    /**
     * Test creating a product with invalid HTTP method.
     *
     * @return void
     */
    public function testCreateProductWithInvalidMethod()
    {
        // Send a PUT request to update the product with invalid data
        $response = $this->put("api/products/{$this->product->id}", $this->requestData);

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
    }
    /**
     * Test creating a product with request timeout.
     *
     * @return void
     */
    public function testCreateProductWithRequestTimeout()
    {
        // Mocking a request timeout scenario (example)
        // This might require additional setup and mocking
        $this->expectException(HttpTimeoutException::class);
        $response = $this->post("api/products", $this->requestData);
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
    }


    /**
     * Test creating a product with too many attempts.
     *
     * @return void
     */
    public function testCreateProductWithTooManyAttempts()
    {
        // Mocking a scenario where there are too many attempts
        RateLimiter::shouldReceive('hit')->andReturn(false);

        // Send multiple requests to create a product
        for ($i = 0; $i < 11; $i++) {
            $response = $this->post("api/products", $this->requestData);
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
    }


    /**
     * Test creating a product with internal server error.
     *
     * @return void
     */
    public function testCreateProductWithInternalServerError()
    {
        // Mocking an internal server error scenario (example)
        // This might require additional setup and mocking
        // For example, you can mock a scenario where an exception occurs during the product creation process

        // Simulate an internal server error by causing an exception
        DB::shouldReceive('beginTransaction')->andThrow(new ApplicationException('Internal server error occurred.'));

        // Send a POST request to create the product
        $response = $this->post("api/products", $this->requestData);

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
    }


    /**
     * Test creating a product with service unavailable.
     *
     * @return void
     */
    public function testCreateProductWithServiceUnavailable()
    {
        // Mock a scenario where the service is unavailable during product creation
        Http::fake(function ($request) {
            return Http::response(['message' => 'Service Unavailable'], Response::HTTP_SERVICE_UNAVAILABLE);
        });

        // Send a POST request to create a product
        $response = $this->post("api/products", $this->requestData);

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
    }
}
