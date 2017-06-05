<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('field_values');
        Schema::dropIfExists('custom_form_fields');
        Schema::dropIfExists('form_details');
        Schema::dropIfExists('form_name');
        Schema::dropIfExists('form_value');
        Schema::dropIfExists('custom_forms');
        Schema::create('forms',function(Blueprint $table){
            $table->increments('id');
            $table->string('form');
            $table->text('json');
            $table->timestamps();
        });
        Schema::create('required_fields',function(Blueprint $table){
            $table->increments('id');
            $table->string('form');
            $table->string('name');
            $table->integer('is_agent_required');
            $table->integer('is_client_required');
            $table->timestamps();
        });
        Schema::table('ticket_form_data',function(Blueprint $table){
            
            $table->string('key');
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
        Schema::dropIfExists('required_fields');
    }
    
    
}
