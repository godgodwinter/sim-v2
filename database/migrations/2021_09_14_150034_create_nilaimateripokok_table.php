<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaimateripokokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilaimateripokok', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_nama')->nullable();
            $table->string('siswa_nis')->nullable();
            $table->string('guru_nomerinduk')->nullable();
            $table->string('guru_nama')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('pelajaran_nama')->nullable();
            $table->string('kompetensidasar_nama')->nullable();
            $table->string('kompetensidasar_kode')->nullable();
            $table->string('kompetensidasar_tipe')->nullable(); //pengetahuan dan ketrampilan (3 adalah pengetahuan dan 4 adalah ketrampilan)
            $table->string('materipokok_nama')->nullable();
            $table->string('status')->nullable(); //tuntas/belumtuntas
            $table->string('nilai')->nullable(); //nilai angka
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
        Schema::dropIfExists('nilaimateripokok');
    }
}
