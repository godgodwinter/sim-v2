<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategorisoalOnBanksoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('banksoal', function (Blueprint $table) {
            $table->string('kategorisoal_nama')->nullable();  //1 = ganda biasa //2 = ganda komplek //3=true and falsev
            $table->longText('gambar')->nullable();
        }); //

        Schema::table('banksoal_jawaban', function (Blueprint $table) {
            $table->string('kategorisoal_nama')->nullable();  //1 = ganda biasa //2 = ganda komplek //3=true and false
            $table->longText('gambar')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
