<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bar_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });
        $version = \Config::get('app.version');
        $date = date('Y-m-d H:i:s');
        //\DB::table('bar_notifications')->insert(['key'=>'new-install','value'=>"Congrates ! You have installed $version",'created_at'=>$date]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bar_notifications');
    }
};
