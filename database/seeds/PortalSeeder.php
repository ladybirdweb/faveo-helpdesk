<?php

use App\Model\helpdesk\Theme\Portal;
use Illuminate\Database\Seeder;

class PortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    /* portal */
        Portal::create(['admin_header_color' => 'skin-yellow', 'agent_header_color' => 'skin-blue', 'client_header_color'=>'null', 'client_button_color' => 'null', 'client_button_border_color' => 'null', 'client_input_fild_color' => 'null', 'logo' => '0', 'icon' => '0']);
    }
}
