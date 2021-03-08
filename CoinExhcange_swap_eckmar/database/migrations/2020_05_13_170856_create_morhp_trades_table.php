<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMorhpTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morph_trades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mid');
            $table->string('state');
            $table->string('input_asset');
            $table->decimal('input_received',24,8)->nullable();
            $table->unsignedBigInteger('input_confirmed_at_height')->nullable();
            $table->string('input_deposit_address');
            $table->string('input_refund_address');
            $table->decimal('input_deposit_limits_min',24,8);
            $table->decimal('input_deposit_limits_max',24,8);
            $table->string('output_asset');
            $table->string('output_address');
            $table->decimal('output_seen_rate',24,8);
            $table->decimal('output_final_rate',24,8)->nullable();
            $table->decimal('output_network_fee',24,8);
            $table->decimal('output_converted_amount',24,8)->nullable();
            $table->string('txid')->nullable();
            $table->string('refund_txid')->nullable();

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
        Schema::dropIfExists('morhp_trades');
    }
}
