<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Booking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->string('IdReservation',100);
            $table->string('Titel',100);
            $table->string('NamaDepan',100);
            $table->string('IdBook',100);
            $table->string('NamaProduct');
            $table->string('Start');
            $table->string('End');
            $table->string('Harga');
            $table->timestamps();
            
            $table->foreign('IdBook')->references('IdBook')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
