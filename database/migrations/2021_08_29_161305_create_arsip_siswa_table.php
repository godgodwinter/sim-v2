<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_siswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->nullable();
            $table->string('nis')->nullable();
            $table->string('agama')->nullable();
            $table->string('tempatlahir')->nullable();
            $table->string('tgllahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('jk')->nullable();
            $table->string('moodleuser')->nullable();
            $table->string('moodlepass')->nullable();
            $table->string('arsipkode')->nullable();
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
        Schema::dropIfExists('arsip_siswa');
    }
}
