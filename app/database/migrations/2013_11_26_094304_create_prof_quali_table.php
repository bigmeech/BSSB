<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfQualiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prof_quali',function(Blueprint $table)
        {
            $table->integer('user_id')->nullable();
            $table->string('inst1_name')->nullable();
            $table->string('inst1_license')->nullable();
            $table->string('inst1_year')->nullable();
            $table->string('inst1_designation')->nullable();
            $table->string('inst1_cert_url')->nullable();

            $table->string('inst2_name')->nullable();
            $table->string('inst2_license')->nullable();
            $table->string('inst2_year')->nullable();
            $table->string('inst2_designation')->nullable();
            $table->string('inst2_cert_url')->nullable();

            $table->string('ref_full_name')->nullable();
            $table->string('ref_occupation')->nullable();
            $table->string('ref_phone_number')->nullable();
            $table->string('ref_address')->nullable();
            $table->string('ref_email')->nullable();
            $table->enum('completed',array('true','false'))->default('false');
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
		Schema::drop('prof_quali');
	}

}