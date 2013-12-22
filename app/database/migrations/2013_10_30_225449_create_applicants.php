<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicants extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applicants',function(Blueprint $table){

            $table->increments("applicant_id");
            $table->string("first_name");
            $table->string('middle_name');
            $table->string('last_name');
            $table->timestamp('date_of_birth');
            $table->string('place_of_birth');
            $table->enum('sex',array('Male','Female'));
            $table->string('phone');
            $table->string('email');
            $table->string('compound_name');
            $table->string('village');
            $table->string('clan');
            $table->string('LGA');
            $table->string('State');
            $table->string('Residential_address');
            $table->integer('upload_id');
            $table->integer('parental_id');
            $table->integer('education_id');
            $table->integer('misc_id');
            $table->integer('referee_id');
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
		Schema::drop('applicants');
	}

}