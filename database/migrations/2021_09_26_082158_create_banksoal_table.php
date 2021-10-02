<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banksoal', function (Blueprint $table) {
            $table->id();
            $table->longText('pertanyaan')->nullable();
            $table->string('nilai')->nullable();
            $table->string('tingkatkesulitan')->nullable();
            $table->string('tingkatkesulitanangka')->nullable();
            $table->string('kodegenerate')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('pelajaran_nama')->nullable();
            $table->longText('materipokok_nama')->nullable();
            $table->string('kompetensidasar_kode')->nullable();
            $table->string('kompetensidasar_tipe')->nullable(); //pengetahuan dan ketrampilan (3 adalah pengetahuan dan 4 adalah ketrampilan)
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
        Schema::dropIfExists('banksoal');
    }
}
