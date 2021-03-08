<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('direction');
            $table->string('base_coin');
            $table->string('other_coin');
            $table->decimal('required_payment',24,8);
            $table->decimal('rate',24,8);
            $table->decimal('actual_rate',24,8);
            $table->decimal('expected_return',24,8);
            $table->decimal('received_balance',24,8)->default(0);
            $table->decimal('service_fee',24,8)->default(0);
            $table->decimal('sent_amount',24,8)->default(0);
            $table->decimal('tx_fee',24,8)->default(0);
            $table->string('deposit_address');
            $table->string('refund_address');
            $table->enum('state',\App\Trade::getAvailableStates());
            $table->string('forward_txid')->nullable();
            $table->dateTime('completed_at')->nullable();
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
        Schema::dropIfExists('trades');
    }
}
