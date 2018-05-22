<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->string('IdProduct',50)->primary();
            $table->string('IdBook',100)->unique();   
            $table->string('Nama');
            $table->string('Tipe');
            $table->text('Deskripsi');
            $table->text('Gambar');
            $table->string('IdProvider',50);
            $table->string('IdService',50);
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
