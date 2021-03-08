<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMorhpTradeForeignKeyToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('morph_trades', function (Blueprint $table) {
            $table->string('trade_id');
            $table->foreign('trade_id')->references('id')->on('trades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('morph_trades', function (Blueprint $table) {
            $table->dropColumn('trade_id');
        });
    }
}
