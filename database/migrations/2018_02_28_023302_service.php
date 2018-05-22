<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Service extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->string('IdService',50)->primary();
            $table->string('Nama');
            $table->text('Deskripsi');
            $table->string('IdProvider',50);
            $table->timestamps();
            
            $table->foreign('IdProvider')->references('IdProvider')->on('provider');
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
