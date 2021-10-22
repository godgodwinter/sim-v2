<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetensidasarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensidasar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('nama')->nullable();
            $table->string('kode')->nullable();
            $table->string('tipe')->nullable();
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
        Schema::dropIfExists('kompetensidasar');
    }
}
