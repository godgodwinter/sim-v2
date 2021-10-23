<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksoaljawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banksoaljawaban', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('jawaban')->nullable();
            $table->string('nilai')->nullable();
            $table->string('gambar')->nullable();
            $table->string('hasil')->nullable();
            $table->string('banksoal_id')->nullable();
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
        Schema::dropIfExists('banksoaljawaban');
    }
}
