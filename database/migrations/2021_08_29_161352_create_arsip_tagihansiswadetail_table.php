<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipTagihansiswadetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_tagihansiswadetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('siswa_nama')->nullable();
            $table->string('siswa_nis')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
            $table->string('nominal')->nullable();
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
        Schema::dropIfExists('arsip_tagihansiswadetail');
    }
}
