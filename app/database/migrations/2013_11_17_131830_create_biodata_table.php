<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBiodataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('biodata',function(Blueprint $table){
            $table->integer('user_id')->unique();
            $table->string('firstName');
            $table->string('middleName');
            $table->string('surname');
            $table->string('dob');
            $table->string('pob');
            $table->enum('gender',array('Male','Female'));
            $table->string('phone');
            $table->string('email');
            $table->text('passportPhoto');
            $table->string('compoundName');
            $table->text('residentialAddress');

            //meternity details
            $table->text('mFirstName')->nullable();
            $table->text('mSurname')->nullable();
            $table->text('maidenName')->nullable();
            $table->text('mVillage')->nullable();
            $table->text('mClan')->nullable();
            $table->text('mLGA')->nullable();

            //patertenity Details
            $table->text('pFirstName')->nullable();
            $table->text('pSurname')->nullable();
            $table->text('paternalName')->nullable();
            $table->text('pVillage')->nullable();
            $table->text('pClan')->nullable();
            $table->text('pLGA')->nullable();
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
		Schema::drop('biodata');
	}

}