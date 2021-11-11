<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('tingkatan')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('semester')->nullable();
            $table->string('tipe')->nullable(); //sekali/bulanan
            $table->string('bln_awal')->nullable(); //perbulan
            $table->string('bln_akhir')->nullable(); //perbulan
            $table->string('tagihan')->nullable(); //perbulan
            $table->string('total')->nullable(); //totalkeseluruhan
            $table->softDeletes();
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
        Schema::dropIfExists('tagihan');
    }
}
