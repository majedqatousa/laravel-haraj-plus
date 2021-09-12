<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('subject');
			$table->text('body');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}