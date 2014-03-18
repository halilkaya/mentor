<?php

use Illuminate\Database\Migrations\Migration;

class CreateMentorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mentor', function($table) {
			$table->increments('id')->unique;
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
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mentor');
	}

}