<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateSchoolarshipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('scholarship',function(Blueprint $table){

            $table->integer("user_id")->unique();
            $table->string("reg_number");
            $table->string('course_of_study');
            $table->enum('scholarship_type',array('PGD','MSC','PHD','DBA'));
            $table->enum('government_bounded',array('YES','NO'));
            $table->enum('already_in_school',array('YES','NO'));
            $table->enum('has_admission',array('YES','NO'));
            $table->text('essay_url');
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
        Schema::drop('scholarship');
	}

}