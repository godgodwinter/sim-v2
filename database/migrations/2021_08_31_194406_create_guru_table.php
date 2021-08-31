<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nomerinduk')->nullable();
            $table->string('jabatan')->nullable(); //guru/walikelas
            $table->string('kategori_nama')->nullable(); //kepsek/guru
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('jk')->nullable();
            $table->string('golongan')->nullable();
            $table->string('pendidikanterakhir')->nullable();
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
        Schema::dropIfExists('guru');
    }
}
