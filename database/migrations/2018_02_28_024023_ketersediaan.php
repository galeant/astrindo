<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ketersediaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ketersediaan', function (Blueprint $table) {
            $table->string('IdBook',100);
            $table->string('Nama',100);
            $table->string('Shortname',100);
            $table->string('Start');
            $table->string('End');
            $table->string('Durasi');
            $table->string('Harga',100);
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
