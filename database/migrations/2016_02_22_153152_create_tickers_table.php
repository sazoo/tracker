<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->increments('id');
			$table->string('high');
			$table->string('last');
			$table->string('timestamp');
			$table->string('bid');
			$table->string('volume');
			$table->string('low');
			$table->string('ask');
			$table->string('open');
			$table->string('average');
			$table->string('buy_four_ema');
			$table->string('buy_twenty_four_ema');
			$table->string('sell_four_ema');
			$table->string('sell_twenty_four_ema');
			$table->string('gain');
			$table->string('loss');
			$table->string('ave_gain');
			$table->string('ave_loss');
			$table->string('rsi');
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
        Schema::drop('tickers');
    }
}
