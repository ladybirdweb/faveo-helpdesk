<?php

use Illuminate\Database\Seeder;
use App\Model\helpdesk\Manage\Tickettype;

class TickettypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Ticket type */
        // Tickettype::create(['name' => 'Default', 'type_desc' => 'Default','status'=>'1','is_default' => '1']);
        Tickettype::create(['name' => 'Question', 'type_desc' => 'Question','status'=>'1','ispublic'=>'1','is_default' => '1']);
         Tickettype::create(['name' => 'Incident', 'type_desc' => 'Incident','is_default' => '0']);
         Tickettype::create(['name' => 'Problem', 'type_desc' => 'Problem','is_default' => '0']);
         Tickettype::create(['name' => 'Feature Request', 'type_desc' => 'Feature Request','is_default' => '0']);
    }
}


