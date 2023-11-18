<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('userID')->unique()->unsigned()->nullable();
			$table->string('email')->unique();
			$table->string('password');
			$table->integer('cardId')->unsigned()->nullable();
			$table->integer('picId')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
