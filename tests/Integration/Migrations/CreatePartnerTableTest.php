<?php

namespace Tests\Integration\Migrations;

use App\Models\Partner;

use App\Models\User;
use Core\Utils\Enums\TypePartnerEnum;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreatePartnerTableTest extends TestCase
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

    $this->assertTrue(Schema::hasTable('partners'));

    $this->assertTrue(Schema::hasTable('clients'));

    $this->assertTrue(Schema::hasTable('suppliers'));

  }

  /** @test */
  public function it_has_expected_columns(): void
  {

    $columns = Schema::getColumnListing('partners');

    $expectedColumns = [
      'id', 'country', 'company', 'type_partner', 'status', 'can_be_delete',
      'created_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    foreach ($expectedColumns as $column) {
      $this->assertTrue(in_array($column, $columns));
    }
  }


  /** @test */

  public function it_creates_partners()
  {
    // create new partner
    $partners = Partner::create([
      'country'           => 'EMP123',
      'company'           => 'aezt',
      'type_partner'      => TypePartnerEnum::DEFAULT,
      'status'            => true,
      'can_be_delete'     => true,
      'created_by'        => $this->get_user_id()
    ]);


    $this->assertDatabaseHas('partners', [
      'country'             => 'EMP123',
      'company'             => "aezt",
      'type_partner'        => TypePartnerEnum::DEFAULT,
      'status'              => true,
      'can_be_delete'       => true,
      'created_by'          => $this->get_user_id()
    ]);
  }
}
