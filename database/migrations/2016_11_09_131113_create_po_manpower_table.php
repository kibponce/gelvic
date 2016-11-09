<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoManpowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_manpower', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')->unsigned();
            $table->foreign('po_id')
                    ->references('id')
                    ->on('po')
                    ->onDelete('cascade');
            $table->integer('manpower_id')->unsigned();
            $table->foreign('manpower_id')
                    ->references('id')
                    ->on('manpower')
                    ->onDelete('cascade');        
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
        Schema::dropIfExists('po_manpower');
    }
}
