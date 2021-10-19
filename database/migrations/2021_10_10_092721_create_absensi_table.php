<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('siswa_nama')->nullable();
            $table->string('siswa_nis')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('tanggal_masuk')->nullable();
            $table->string('ket')->nullable();
            $table->string('guru_nomerinduk')->nullable();
            $table->string('guru_nama')->nullable();
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
        Schema::dropIfExists('absensi');
    }
}
