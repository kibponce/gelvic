<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')->unsigned();
            $table->foreign('po_id')
                    ->references('id')
                    ->on('po')
                    ->onDelete('cascade');
            $table->string('description');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_cost', 20, 2);
            $table->integer('duration');
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
        Schema::dropIfExists('po_materials');
    }
}
