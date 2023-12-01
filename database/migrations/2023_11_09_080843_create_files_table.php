<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration {

	public function up()
	{
		Schema::create('files', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('cardId')->unsigned();
			$table->string('filePath')->nullable();
			$table->string('fileType')->nullable();
			$table->string('detail')->nullable();
			$table->string('fileName')->nullable();
			$table->boolean('drugSens');
		});
	}

	public function down()
	{
		Schema::drop('files');
	}
}