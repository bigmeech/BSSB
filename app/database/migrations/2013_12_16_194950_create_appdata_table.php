<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppdataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('application_data',function(Blueprint $table){
            $table->integer("user_id")->unique();
            $table->integer("app_progress")->default(0);
            $table->enum("scholarship_form_complete",array('false','true'))->default('false');
            $table->enum("biodata_form_complete",array('false','true'))->default('false');
            $table->enum("basic_quali_form_complete",array('false','true'))->default('false');
            $table->enum("higher_inst_form_complete",array('false','true'))->default('false');
            $table->enum("prof_quali_form_complete",array('false','true'))->default('false');

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
		Schema::drop('application_data');
	}

}