<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kko', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable(); // kata-kata
            $table->string('tipe')->nullable();  // c1,c2= mudah ,, ,c3,c4 sedang ,, c5,c6 = sulit
            $table->string('keterangan')->nullable();  //sulit , sedang, mudah
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
        Schema::dropIfExists('kko');
    }
}
