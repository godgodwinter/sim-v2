<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaipelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilaipelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_nama')->nullable();
            $table->string('siswa_nis')->nullable();
            $table->string('guru_nomerinduk')->nullable();
            $table->string('guru_nama')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('jenisnilai_nama')->nullable();
            $table->string('pelajaran_nama')->nullable();
            $table->string('nilai')->nullable();
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
        Schema::dropIfExists('nilaipelajaran');
    }
}
