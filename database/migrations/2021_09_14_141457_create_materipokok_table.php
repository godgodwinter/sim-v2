<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateripokokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materipokok', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable(); 
            $table->string('link')->nullable(); 
            $table->string('tapel_nama')->nullable(); 
            $table->string('kelas_nama')->nullable(); 
            $table->string('pelajaran_nama')->nullable(); 
            $table->string('kompetensidasar_nama')->nullable(); 
            $table->string('kompetensidasar_kode')->nullable(); 
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
        Schema::dropIfExists('materipokok');
    }
}
