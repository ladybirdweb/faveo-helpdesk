<?php

namespace Database\Seeders\v_2_0_0;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creating an user
        $str = 'demopass';
        $password = Hash::make($str);
        $user = User::create([
            'first_name'   => 'Demo',
            'last_name'    => 'Admin',
            'email'        => null,
            'user_name'    => 'demo_admin',
            'password'     => $password,
            'assign_group' => 1,
            'primary_dpt'  => 1,
            'active'       => 1,
            'role'         => 'admin',
        ]);
        // checking if the user have been created
    }
}
