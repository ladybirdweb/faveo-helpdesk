<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmtpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('send_mail', function (Blueprint $table) {
			$table->increments('id');
			$table->string('host');
			$table->string('port');
			$table->string('encryption');
			$table->string('name');
			$table->string('email');
			$table->string('password');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('send_mail');
	}

}
