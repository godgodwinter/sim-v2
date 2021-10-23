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
            $table->bigIncrements('id');
            $table->longText('pertanyaan')->nullable();
            $table->string('nilai')->nullable();
            $table->string('tingkatkesulitan')->nullable();
            $table->string('tingkatkesulitanangka')->nullable();
            $table->longText('gambar')->nullable();
            $table->string('kategorisoal_nama')->nullable();
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
        Schema::dropIfExists('banksoal');
    }
}
