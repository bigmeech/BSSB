<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormComplete extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('form_complete',function(Blueprint $table){
            $table->integer('user_id');
            $table->enum('scholarship_app_completed',array(0,1))->default(0);
            $table->enum('biodata_completed',array(0,1))->default(0);
            $table->enum('basic_qualification_completed',array(0,1))->default(0);
            $table->enum('higher_institution_completed',array(0,1))->default(0);
            $table->enum('professional_qualification_completed',array(0,1))->default(0);
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
		Schema::drop('form_complete');
	}

}