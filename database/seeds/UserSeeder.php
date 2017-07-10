<?php

use Illuminate\Database\Seeder;

   
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
        $user = User::create([
                    'first_name' => 'Demo',
                    'last_name' => 'Admin',
                    'email' => null,
                    'user_name' => 'demo_admin',
                    'password' => $password,
                    //'assign_group' => 1,
                    'primary_dpt' => 1,
                    'active' => 1,
                    'role' => 'admin',
        ]);
        $permisions = '{"create_ticket":"1","edit_ticket":"1","close_ticket":"1","transfer_ticket":"1","delete_ticket":"1","assign_ticket":"1","access_kb":"1","ban_email":"1","organisation_document_upload":"1","email_verification":"1","mobile_verification":"1","account_activate":"1"}';
        $user->permision()->create([
            'permision'=>$permisions
        ]);
        // checking if the user have been created
       
        
    }
}
