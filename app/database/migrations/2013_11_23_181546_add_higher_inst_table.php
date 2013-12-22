<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHigherInstTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('higher_inst',function(Blueprint $table)
        {
            $table->integer('user_id')->unique();
            $table->string('inst1_name');
            $table->string('inst1_cos');
            $table->string('inst1_duration');
            $table->string('inst1_cert');
            $table->string('inst1_admission_year');
            $table->string('inst1_grad_year');
            $table->string('inst1_exp_grad_year');
            $table->string('inst1_grade');
            $table->string('inst1_cert_url');
            $table->string('inst1_reason');

            $table->string('inst2_name')->nullable();
            $table->string('inst2_cos')->nullable();
            $table->string('inst2_duration')->nullable();
            $table->string('inst2_cert')->nullable();
            $table->string('inst2_admission_year')->nullable();
            $table->string('inst2_grad_year')->nullable();
            $table->string('inst2_exp_grad_year')->nullable();
            $table->string('inst2_grade')->nullable();
            $table->string('inst2_cert_url')->nullable();
            $table->string('inst2_reason')->nullable();

            $table->string('nysc_state');
            $table->string('nysc_call_up');
            $table->string('nysc_batch');
            $table->string('nysc_year');
            $table->string('nysc_completion_year');
            $table->enum('nysc_exempted',array('YES','NO'));
            $table->string('reason_exempted');
            $table->string('nysc_cert');

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
		Schema::drop('higher_inst');
	}

}