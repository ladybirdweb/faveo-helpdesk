<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('comment', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('article_id')->unsigned();
			$table->foreign('article_id')->references('id')->on('article');
			$table->string('name');
			$table->string('email');
			$table->string('website');
			$table->string('comment');
			$table->boolean('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('comments');
	}

}
