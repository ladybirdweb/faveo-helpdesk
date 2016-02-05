<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class SettingsRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings_ratings', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('rating_name');
			$table->integer('publish');
			$table->integer('modify');
                        $table->string('slug')->unique();
			$table->timestamps();
		});
                DB::table('settings_ratings')->insert(array( 
        array(
            'rating_name' => 'Overall Rating',
            'publish' => '1',
            'modify' => '1',
            'slug' => Str::slug(ucfirst('Overall Rating'))
        ),
        array(
            'rating_name' => 'Reply Rating',
            'publish' => '1',
            'modify' => '1',
            'slug' => Str::slug(ucfirst('Reply Rating'))
        )
                    )
    );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings_ratings');
	}

}
