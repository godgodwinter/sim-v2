<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratebanksoalJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generatebanksoal_jawaban', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('banksoaljawaban_id')->nullable();
            $table->string('pilihan')->nullable();
            $table->string('benarsalah')->nullable(); //if lebih dari 0 == benar
            $table->string('generatebanksoal_detail_id')->nullable();
            $table->string('generatebanksoal_id')->nullable();
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
        Schema::dropIfExists('generatebanksoal_jawaban');
    }
}
