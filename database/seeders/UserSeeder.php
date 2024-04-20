<?php

namespace Database\Seeders;

use App\Models\Oauths\OauthClient;
use App\Models\Oauths\OauthPersonalAccessClient;
use App\Models\Permission;
use App\Models\User;
use App\Models\Person;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $person = Person::create([
            'last_name'     => $faker->lastName,
            'first_name'    => $faker->firstName,
            'middle_name'   => [$faker->firstName, $faker->firstName],
            'sex'           => $faker->randomElement(["male", "female"])
        ]);

        $user = $person->user()->create([
            'login_channel' => "email",
            'type_of_account' => "personal",
            'email' => $faker->email,
            'phone_number'    => ["country_code"=> 229, "number" => (int) str_replace("+", "", $faker->e164PhoneNumber)]
        ]);

        $role = Role::first();

        $user->assignRole($role->id);

        $credential = $user->credential()->create([
            'created_by' => $user->id,
            'password'  => Hash::make("password"), 'identifier' => "{$user->{$user->login_channel}}"
        ]);

        $client = new OauthClient([
            "id" => Str::orderedUuid(),
            "user_id" => $credential->id,
            "secret" =>   bin2hex(random_bytes(32)),
            "name" => "Password Grant {$user->full_name}",
            "revoked" => 0,
            "password_client" => 1,
            "personal_access_client" => 0,
            "redirect" => config('app.url'),
        ]);
        $client->save();

        $role->permissions()->attach(Permission::distinct()->get()->pluck("id")->toArray());

        /*OauthPersonalAccessClient::create(["client_id" => $client->id]); */
    }
}
