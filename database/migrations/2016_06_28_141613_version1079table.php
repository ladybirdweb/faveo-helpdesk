<?php

use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings_system = DB::table('settings_system')->where('id', '=', '1')->first();
        if ($settings_system != null) {
            DB::table('common_settings')
                    ->insert(
                        ['option_name' => 'enable_rtl', 'option_value' => ''],
                        ['option_name' => 'user_set_ticket_status', 'status' => 1],
                        ['option_name' => 'send_otp', 'status' => 0],
                        ['option_name' => 'email_mandatory', 'status' => 1]
                    );
        }

        if (Schema::hasTable('common_settings')) {
            $settings = DB::table('common_settings')->where('option_name', 'itil')->first();
            if (!$settings) {
                DB::table('common_settings')->insert(['option_name' => 'itil', 'status' => '0']);
            }
        }
    }
};
