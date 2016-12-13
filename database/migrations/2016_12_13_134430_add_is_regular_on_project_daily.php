<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRegularOnProjectDaily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_dailies', function (Blueprint $table) {
            $table->boolean("isRegular")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_dailies', function (Blueprint $table) {
            $table->dropColumn('isRegular');
        });
    }
}
