<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipTagihanaturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_tagihanatur', function (Blueprint $table) {
            $table->id();
            $table->string('kelas_nama')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('nominaltagihan')->nullable();
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('arsip_tagihanatur');
    }
}
