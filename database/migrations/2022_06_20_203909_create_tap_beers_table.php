<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tap_beers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tap_id')->constraint();
            $table->foreignId('beer_id')->constraint();
            $table->dateTime('on_from');
            $table->dateTime('on_to')->nullable();

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
        Schema::dropIfExists('tap_beers');
    }
};
