<?php

use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function($table) {
			$table->increments('id')->unique;
			$table->integer('question_id');
			$table->integer('mentor_id');
			$table->integer('mentee_id');
			$table->text('answer');
			$table->dateTime('date_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answers');
	}

}