<?php

namespace Database\Seeders;

use App\Models\Oauths\OauthClient;
use App\Models\Oauths\OauthPersonalAccessClient;
use App\Models\User;
use App\Models\Person;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person = Person::create([
            'last_name'     => "DOE",
            'first_name'    => "John",
            'middle_name'   => ["Phillipe"],
            'sex'           => 'male'
        ]);

        $user = $person->user()->create([
            'type_of_account' => "personal",
            'identifier' => "johndoe@gmail.com",
            'password' => Hash::make("password"),
            'email' => "johndoe@gmail.com",
            'phone_number'    => ["country_code"=> 229, "number" => 87321067]
        ]);

        $user->assignRole(Role::first()->id);

        $credential = $user->credential()->create([
            'created_by' => $user->id,
            'password'  => Hash::make("password"), 'identifier' => "{$user->{$user->login_channel}}"
        ]);

        $client = OauthClient::create([
            "id" => Str::orderedUuid(),
            "user_id" => $credential->id,
            "secret" =>   bin2hex(random_bytes(32)),
            "name" => "Password Grant {$user->full_name}",
            "revoked" => 0,
            "password_client" => 1,
            "personal_access_client" => 0,
            "redirect" => config('app.url'),
        ]);

        /*OauthPersonalAccessClient::create(["client_id" => $client->id]); */
    }
}
