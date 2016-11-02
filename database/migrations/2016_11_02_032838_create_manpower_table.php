<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManpowerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manpower', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('employee_id')->unique();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('position');
			$table->text('address');
			$table->date('birthdate');
			$table->decimal('rate');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('manpower');
	}

}
