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
