<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ticket_number');
			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
			$table->integer('dept_id')->unsigned()->nullable()->index('dept_id');
			$table->integer('team_id')->unsigned()->nullable()->index('team_id');
			$table->integer('priority_id')->unsigned()->nullable()->index('priority_id');
			$table->integer('sla')->unsigned()->nullable()->index('sla');
			$table->integer('help_topic_id')->unsigned()->nullable()->index('help_topic_id');
			$table->integer('status')->unsigned()->nullable()->index('status');
			$table->integer('flags');
			$table->integer('ip_address');
			$table->integer('assigned_to')->unsigned()->nullable()->index('assigned_to');
                        $table->integer('rating');
			$table->integer('ratingreply');
			$table->integer('lock_by');
			$table->integer('lock_at');
			$table->integer('source')->unsigned()->nullable()->index('source');
			$table->integer('isoverdue');
			$table->integer('reopened');
			$table->integer('isanswered');
			$table->integer('html');
			$table->integer('is_deleted');
			$table->integer('closed');
			$table->boolean('is_transferred');
			$table->dateTime('transferred_at');
			$table->dateTime('reopened_at')->nullable();
			$table->dateTime('duedate')->nullable();
			$table->dateTime('closed_at')->nullable();
			$table->dateTime('last_message_at')->nullable();
			$table->dateTime('last_response_at')->nullable();
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
		Schema::drop('tickets');
	}

}
