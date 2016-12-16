<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingRatesOnPo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po', function (Blueprint $table) {
            $table->decimal('type_a', 20, 2)->nullable()->default(0);
            $table->decimal('type_b', 20, 2)->nullable()->default(0);
            $table->decimal('type_c', 20, 2)->nullable()->default(0);
            $table->decimal('materials', 20, 2)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po', function (Blueprint $table) {
            $table->dropColumn("materials");
            $table->dropColumn("type_c");
            $table->dropColumn("type_b");
            $table->dropColumn("type_a");$v->rate = $po_id->type_a;    
        });
    }
}
