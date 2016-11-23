<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_id')->nullable()->unsigned();
            $table->foreign('equipment_id')
                    ->references('id')
                    ->on('equipment')
                    ->onDelete('cascade');
            $table->integer('po_id')->nullable()->unsigned();
            $table->foreign('po_id')
                    ->references('id')
                    ->on('po')
                    ->onDelete('cascade');
            $table->decimal("expense", 20, 2)->nullable();
            $table->decimal("rate", 20, 2);
            $table->integer("duration")->nullable();
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
        Schema::dropIfExists('po_equipment');
    }
}
