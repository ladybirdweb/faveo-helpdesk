<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('article_relationship', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('article_id')->unsigned();
			$table->foreign('article_id')->references('id')->on('article');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('category');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('article_relationship');
	}

}
