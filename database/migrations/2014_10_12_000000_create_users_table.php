<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $t)  {
            $t->increments('id');
            //$t->string('username')->unique()->nullable();
            $t->string('email')->unique();
            $t->string('password', 60);
            $t->rememberToken();
            $t->string('first_name')->nullable();
            $t->string('last_name')->nullable();
            //$t->string('phone_number', 10);
            $t->string('zip_code', 10)->nullable();
            $t->boolean('confirmed')->default(0);
            $t->timestamp('last_logged_in')->nullable();
            $t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
