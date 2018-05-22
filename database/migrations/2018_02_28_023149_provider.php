<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Provider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider', function (Blueprint $table) {
            $table->string('IdProvider',55)->primary();
            $table->string('Shortname');
            $table->string('Nama');
            $table->text('Deskripsi');
            $table->text('Alamat');
            $table->string('Kota', 20);
            $table->string('Provinsi',20);
            $table->string('KodePos',10);
            $table->string('Telepon',18);
            $table->string('Email',50);
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
        //
    }
}
