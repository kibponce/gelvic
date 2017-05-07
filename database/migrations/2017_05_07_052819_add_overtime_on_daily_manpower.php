<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOvertimeOnDailyManpower extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_dailies_manpower', function (Blueprint $table) {
            $table->boolean("is_overtime")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_dailies_manpower', function (Blueprint $table) {
            $table->dropColumn('is_overtime');
        });
    }
}
