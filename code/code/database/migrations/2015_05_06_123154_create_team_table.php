<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('teams', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('status');
			$table->string('team_lead');
			$table->boolean('assign_alert');
			$table->string('admin_notes');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('teams');
	}

}
