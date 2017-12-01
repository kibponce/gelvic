<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateAndOrOnPoEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_materials', function (Blueprint $table) {
            $table->string("or_number")->nullable();
			$table->date("or_date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_materials', function (Blueprint $table) {
            $table->dropColumn('or_date');
			$table->dropColumn('or_number');
        });
    }
}
