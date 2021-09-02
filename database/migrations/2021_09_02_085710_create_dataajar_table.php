<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataajar', function (Blueprint $table) {
            $table->id();
            $table->string('pelajaran_nama')->nullable();
            $table->string('pelajaran_tipepelajaran')->nullable();
            $table->string('pelajaran_jurusan')->nullable();
            $table->string('pelajaran_kelas_nama')->nullable(); //optional  jika tipepelajaran khusus
            $table->string('kelas_nama')->nullable(); //bukan dari table pelajaran
            $table->string('guru_nomerinduk')->nullable(); //
            $table->string('guru_nama')->nullable(); //
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
        Schema::dropIfExists('dataajar');
    }
}
