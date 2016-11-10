<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDailyManpower extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_dailies_manpower', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_daily_id')->unsigned();
            $table->foreign('po_daily_id')
                    ->references('id')
                    ->on('po_dailies')
                    ->onDelete('cascade');
            $table->integer('manpower_id')->unsigned();
            $table->foreign('manpower_id')
                    ->references('id')
                    ->on('manpower')
                    ->onDelete('cascade');
            $table->dateTime('in')->nullable(); 
            $table->dateTime('out')->nullable(); 
            $table->decimal('rate', 20, 2)->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_dailies_manpower');
    }
}
