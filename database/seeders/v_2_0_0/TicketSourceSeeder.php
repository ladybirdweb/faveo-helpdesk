<?php

namespace Database\Seeders\v_2_0_0;

use App\Model\helpdesk\Ticket\Ticket_source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Ticket_source::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Ticket_source::create(['name' => 'Web', 'value' => 'Web', 'css_class' => 'fa fa-globe']);
        Ticket_source::create(['name' => 'Email', 'value' => 'E-mail', 'css_class' => 'fa fa-envelope']);
        Ticket_source::create(['name' => 'Agent', 'value' => 'Agent Panel', 'css_class' => 'fa fa-user']);
        Ticket_source::create(['name' => 'Facebook', 'value' => 'Facebook', 'css_class' => 'fa fa-facebook']);
        Ticket_source::create(['name' => 'Twitter', 'value' => 'Twitter', 'css_class' => 'fa fa-twitter']);
        Ticket_source::create(['name' => 'Call', 'value' => 'Call', 'css_class' => 'fa fa-phone']);
        Ticket_source::create(['name' => 'Chat', 'value' => 'Chat', 'css_class' => 'fa fa-comment']);
    }
}
