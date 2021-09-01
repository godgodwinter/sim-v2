<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('tipepelajaran')->nullable(); //tipe_mapel yaitu//mulok/umum/jurusan ,, dari kategori_nama where tipepelajaran
            $table->string('jurusan')->nullable(); //jurusan ,jika mapel tipe jurusan , jika bukan maka null,, dari kategori_nama where jurusan
            $table->string('kkm')->nullable();
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
        Schema::dropIfExists('pelajaran');
    }
}
