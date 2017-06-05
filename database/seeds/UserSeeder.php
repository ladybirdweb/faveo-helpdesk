<?php

use Illuminate\Database\Seeder;

use App\Model\helpdesk\Agent\DepartmentAssignAgents;   
use App\User;

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
        $str = "password";
        $password = \Hash::make($str);
        User::create([
                    'first_name' => 'Demo',
                    'last_name' => 'Admin',
                    'email' => null,
                    'user_name' => 'demo_admin',
                    'password' => $password,
                    'assign_group' => 1,
                    'primary_dpt' => 1,
                    'active' => 1,
                    'role' => 'admin',
        ]);
        
    }
}
