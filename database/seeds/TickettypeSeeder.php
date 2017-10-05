<?php

use App\Model\helpdesk\Manage\Tickettype;
use Illuminate\Database\Seeder;

class TickettypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tickettype::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /* Ticket type */
        // Tickettype::create(['name' => 'Default', 'type_desc' => 'Default','status'=>'1','is_default' => '1']);
        Tickettype::create(['name' => 'Question', 'type_desc' => 'Question', 'status'=>'1', 'ispublic'=>'1', 'is_default' => '1']);
        Tickettype::create(['name' => 'Incident', 'type_desc' => 'Incident', 'is_default' => '0']);
        Tickettype::create(['name' => 'Problem', 'type_desc' => 'Problem', 'is_default' => '0']);
        Tickettype::create(['name' => 'Feature Request', 'type_desc' => 'Feature Request', 'is_default' => '0']);
    }
}
