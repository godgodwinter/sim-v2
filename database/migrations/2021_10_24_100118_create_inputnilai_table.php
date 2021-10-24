<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputnilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputnilai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nilai')->nullable();
            $table->string('status')->nullable();
            $table->string('siswa_id')->nullable();
            $table->string('materipokok_id')->nullable();
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
        Schema::dropIfExists('inputnilai');
    }
}
