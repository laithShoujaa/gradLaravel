<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('cardId')->references('id')->on('cards')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('picId')->references('id')->on('files')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->foreign('userID')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->foreign('picId')->references('id')->on('files')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('files', function(Blueprint $table) {
			$table->foreign('cardId')->references('id')->on('cards')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_cardId_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_picId_foreign');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->dropForeign('cards_userID_foreign');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->dropForeign('cards_picId_foreign');
		});
		Schema::table('files', function(Blueprint $table) {
			$table->dropForeign('files_cardId_foreign');
		});
	}
}