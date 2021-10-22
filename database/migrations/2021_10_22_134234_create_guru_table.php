<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('nomerinduk');
            $table->string('jabatan')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('jk')->nullable();
            $table->string('golongan')->nullable();
            $table->string('pendidikanterakhir')->nullable();
            $table->string('kategori_id')->nullable();
            $table->string('users_id')->nullable();
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
        Schema::dropIfExists('guru');
    }
}
