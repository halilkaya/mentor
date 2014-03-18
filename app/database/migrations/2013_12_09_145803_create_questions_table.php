<?php

use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function($table) {
			$table->increments('id')->unique;
			$table->integer('mentor_id');
			$table->integer('mentee_id');
			$table->integer('category_id');
			$table->string('title');
			$table->text('question');
			$table->dateTime('date_time');
			$table->boolean('isActive');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}