<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('social', function (Blueprint $table) {
			$table->increments('id');
			$table->string('linkedin');
			$table->string('stumble');
			$table->string('google');
			$table->string('deviantart');
			$table->string('flickr');
			$table->string('skype');
			$table->string('rss');
			$table->string('twitter');
			$table->string('facebook');
			$table->string('youtube');
			$table->string('vimeo');
			$table->string('pinterest');
			$table->string('dribbble');
			$table->string('instagram');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('social');
	}

}
