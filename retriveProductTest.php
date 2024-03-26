<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tests\TestCase;
use Illuminate\Http\Client\RequestException as HttpTimeoutException;

class RetrieveProductTest extends TestCase
{
    use RefreshDatabase;

    protected $product;

    /**
     * Set up the test environment before each test method runs.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database
        $this->seed(DatabaseSeeder::class);

        // Initialize any data or resources needed for tests
        $this->product = Product::create([
            "name" => $this->faker->unique()->name,
            "price" => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1000 with 2 decimal places
        ]);
    }

    /**
     * Tear down the test environment after each test method runs.
     */
    protected function tearDown(): void
    {
        // Clean up any resources used in the tests
        $this->product->delete();
        $this->product = null;

        parent::tearDown();
    }

    /**
     * Test retrieving an existing product.
     *
     * @return void
     */
    public function testRetrieveExistingProduct()
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
    }

    /**
     * Test retrieving a non-existing product.
     *
     * @return void
     */
    public function testRetrieveNonExistingProduct()
    {
        // Send a GET request to retrieve a non-existing product
        $response = $this->get("api/products/" . $this->product->id);

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
     * Test retrieving a product with invalid ID format.
     *
     * @return void
     */
    public function testRetrieveProductWithInvalidId()
    {
        $invalidUuid = Uuid::uuid4()->toString();

        // Send a GET request with an invalid product ID format
        $response = $this->get("api/products/{$invalidUuid}4");

        // Assert that the response is a bad request
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        
        // Additional assertions can be added here
    }

    /**
     * Test retrieving a product without authentication.
     *
     * @return void
     */
    public function testRetrieveProductWithoutAuthentication()
    {
        // Disable authentication middleware
        $this->withoutMiddleware();

        // Send a GET request to retrieve a product without authentication
        $response =  $this->getJson("api/products/" . $this->product->id);

        // Assert that the response is unauthorized
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Additional assertions can be added here
    }

    /**
     * Test retrieving a product with insufficient permissions.
     *
     * @return void
     */
    public function testRetrieveProductWithInsufficientPermissions()
    {
        // Mock the authorization check to always return false
        Gate::shouldReceive('allows')->andReturn(false);

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


        
        // Send a GET request to retrieve the product as the user with insufficient permissions
        $response = $this->actingAs($user)->get("api/products/" . $this->product->id);

        // Assert that the response is forbidden
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Additional assertions can be added here
    }

    /**
     * Test retrieving a product with invalid HTTP method.
     *
     * @return void
     */
    public function testRetrieveProductWithInvalidMethod()
    {
        // Send a POST request instead of a GET request to retrieve a product
        $response = $this->post("api/products/" . $this->product->id);

        // Assert that the response status is "Method Not Allowed"
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Test retrieving a product with request timeout.
     *
     * @return void
     */
    public function testRetrieveProductWithRequestTimeout()
    {
        // Mocking a request timeout scenario (example)
        // This might require additional setup and mocking
        $this->expectException(HttpTimeoutException::class);
        $response = $this->get("api/products/" . $this->product->id);
        $response->assertStatus(Response::HTTP_REQUEST_TIMEOUT);
    }

    /**
     * Test retrieving a product with internal server error.
     *
     * @return void
     */
    public function testRetrieveProductWithInternalServerError()
    {
        $response = $this->get("api/products/" . $this->product->id);
        // Mocking an internal server error scenario (example)
        // This might require additional setup and mocking
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

        // Additional assertions can be added here
    }

    /**
     * Test retrieving a product with service unavailable.
     *
     * @return void
     */
    public function testRetrieveProductWithServiceUnavailable()
    {
        // Mocking a service unavailable scenario (example)
        // This might require additional setup and mocking
        $response = $this->get("api/products/" . $this->product->id);
        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE);

        // Additional assertions can be added here
    }
}
