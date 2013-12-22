<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveFullNameColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function(Blueprint $table){
            $table->dropColumn('full_name');
        });
	}

	public function down()
	{
		Schema::table('users',function(Blueprint $table){
            $table->string('full_name');
        });
	}

}