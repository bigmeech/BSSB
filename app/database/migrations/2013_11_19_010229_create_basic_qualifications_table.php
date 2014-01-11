<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBasicQualificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('basic_qualifications',function(Blueprint $table){

            //sitting 1
            $table->integer('user_id')->unique();
            $table->string('s1_exam');
            $table->string('s1_exam_number');
            $table->string('s1_center_name');
            $table->string('s1_exam_year');
            $table->string('s1_year_admitted');
            $table->string('s1_year_graduated');
            $table->string('s1_credits');
            $table->text('s1_subAndGrades');
            $table->text('s1_cert_url');

            //sitting 2
            $table->string('s2_exam')->nullable();
            $table->string('s2_exam_number')->nullable();
            $table->string('s2_center_name')->nullable();
            $table->string('s2_exam_year')->nullable();
            $table->string('s2_year_admitted')->nullable();
            $table->string('s2_year_graduated')->nullable();
            $table->string('s2_credits')->nullable();
            $table->text('s2_subAndGrades')->nullable();
            $table->text('s2_cert_url')->nullable();

            //alavels
            $table->string('a_exam')->nullable();
            $table->string('a_exam_number')->nullable();
            $table->string('a_center_name')->nullable();
            $table->string('a_credits')->nullable();
            $table->text('a_subAndGrades')->nullable();
            $table->text('a_cert_url')->nullable();

            //jamb
            $table->string('jamb_center_name');#
            $table->string('jamb_exam_number');
            $table->string('jamb_exam_year');
            $table->string('jamb_total_score');
            $table->text('jamb_subAndScore');
            $table->text('jamb_cert_url');

            //timestamps
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
		Schema::drop('basic_qualifications');
	}

}