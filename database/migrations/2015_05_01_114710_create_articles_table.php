<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('article', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('slug');
			$table->longText('description');
			$table->boolean('status');
			$table->boolean('type');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('articles');
	}

}
