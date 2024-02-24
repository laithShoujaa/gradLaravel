<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration {

	public function up()
	{
		Schema::create('cards', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('userID')->unsigned();
			$table->enum('typeCard', array('nfc', 'smartHome'));
			$table->string('name');
			$table->date('birthDate')->nullable();
			$table->enum('gender', array('male', 'female'))->nullable();
			$table->string('location')->nullable();
            $table->enum('blood',['AB+','AB-','A+','A-','B+','B-','O+','O-'])->nullable();
			$table->string('phone')->nullable();
			$table->bigInteger('passcode')->nullable();
			$table->string('macAddress')->nullable();
			$table->integer('picId')->unsigned()->nullable();

		});
	}

	public function down()
	{
		Schema::drop('cards');
	}
}
