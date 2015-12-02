<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('side1', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->mediumText('content');
			$table->timestamps();
		});
		Schema::create('side2', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->mediumText('content');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('side1');
		Schema::drop('side2');
	}

}
