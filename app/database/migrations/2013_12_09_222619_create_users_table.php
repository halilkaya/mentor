<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			$table->increments('id')->unique;
			$table->string('user_type', 6);
			$table->string('username', 30);
			$table->string('password', 50);
			$table->string('name', 25);
			$table->string('surname', 25);
			$table->string('department');
			$table->string('email');
			$table->string('class');
			$table->string('available_time');
			$table->text('help_topics');
			$table->text('hobbies');
			$table->text('description');
			$table->dateTime('created');
			$table->dateTime('last_login');
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