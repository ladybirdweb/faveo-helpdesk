<?php

namespace Tests\Unit;

use App\User;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_store_user()
    {
        $faker = FakerFactory::create();

        //Create User -> Agent

        //$str = Str::random(10);
        $str = 'demopass';
        $password = Hash::make($str);
        $email = $faker->unique()->email();
        $user = new User([
            'first_name'   => $faker->firstName(),
            'last_name'    => $faker->lastName(),
            'email'        => $email,
            'user_name'    => $faker->unique()->userName(),
            'password'     => $password,
            'assign_group' => 1,
            'primary_dpt'  => 1,
            'active'       => 1,
            'role'         => 'agent',
            'agent_tzone'  => 81,
        ]);
        $user->save();

        // Check if data is inserted
        $this->assertDatabaseHas('users', ['email' => $email]);

        // Authenticate as the created user
        $this->actingAs($user);

        $this->assertAuthenticated();

        $this->assertDatabaseMissing('users', ['email' => $email]);

    }
}
