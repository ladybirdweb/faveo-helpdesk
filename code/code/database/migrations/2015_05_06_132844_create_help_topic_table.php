<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHelpTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('help_topic', function (Blueprint $table) {
			$table->increments('id');
			$table->string('topic');
			$table->string('parent_topic');
			$table->string('custom_form');
			$table->string('department');
			$table->string('ticket_status');
			$table->string('priority');
			$table->string('sla_plan');
			$table->string('thank_page');
			$table->string('ticket_num_format');
			$table->string('internal_notes');
			$table->boolean('status');
			$table->boolean('type');
			$table->boolean('auto_assign');
			$table->boolean('auto_response');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('help_topic');
	}

}
