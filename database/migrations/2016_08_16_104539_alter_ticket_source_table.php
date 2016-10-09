<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterTicketSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ticket_source', 'css_class')) {
            Schema::table('ticket_source', function (Blueprint $table) {
                $table->string('css_class');
            });
        }
        DB::table('ticket_source')->delete();
        $values = $this->values();
        foreach ($values as $value) {
            DB::table('ticket_source')->insert($value);
        }
    }

    public function values()
    {
        return[
            ['name' => 'web', 'value' => 'Web', 'css_class' => 'fa fa-internet-explorer'],
            ['name' => 'email', 'value' => 'E-mail', 'css_class' => 'fa fa-envelope'],
            ['name' => 'agent', 'value' => 'Agent Panel', 'css_class' => 'fa fa-envelope'],
            ['name' => 'facebook', 'value' => 'Facebook', 'css_class' => 'fa fa-facebook'],
            ['name' => 'twitter', 'value' => 'Twitter', 'css_class' => 'fa fa-twitter'],
            ['name' => 'call', 'value' => 'Call', 'css_class' => 'fa fa-phone'],
            ['name' => 'chat', 'value' => 'Chat', 'css_class' => 'fa fa-comment'],
        ];
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_source', function (Blueprint $table) {
            //
        });
    }
}
