<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratebanksoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generatebanksoal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jml')->nullable();
            $table->string('soal')->nullable();
            $table->string('jawaban')->nullable();
            $table->string('mudah')->nullable();
            $table->string('sedang')->nullable();
            $table->string('sulit')->nullable();
            $table->string('tgl')->nullable();
            $table->string('dataajar_id')->nullable();
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
        Schema::dropIfExists('generatebanksoal');
    }
}
