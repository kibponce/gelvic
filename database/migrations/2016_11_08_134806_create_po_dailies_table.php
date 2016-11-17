<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_dailies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')->unsigned()->nullable();
            $table->foreign('po_id')
                    ->references('id')
                    ->on('po')
                    ->onDelete('cascade');
            $table->date('date');
            $table->boolean('status')->default(0);
            $table->text('activity')->nullable();
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
        Schema::dropIfExists('po_dailies');
    }
}
