<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoDailyEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_dailies_equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_id')->nullable()->unsigned();
            $table->foreign('equipment_id')
                    ->references('id')
                    ->on('equipment')
                    ->onDelete('cascade');
            $table->integer('po_daily_id')->nullable()->unsigned();
            $table->foreign('po_daily_id')
                    ->references('id')
                    ->on('po_dailies')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('po_dailies_equipment');
    }
}
