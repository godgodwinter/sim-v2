<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipenilaiSemesterNamaOnJenisnilaiAndSomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenisnilai', function (Blueprint $table) {
            $table->string('tipe')->nullable();  //pengetahuan dan ketrampilan
            $table->string('semester_nama')->nullable();
        });

        Schema::table('pelajaran', function (Blueprint $table) {
            $table->string('semester_nama')->nullable();
        });
        Schema::table('ekstrakulikuler', function (Blueprint $table) {
            $table->string('semester_nama')->nullable();
        });
        Schema::table('kepribadian', function (Blueprint $table) {
            $table->string('semester_nama')->nullable();
        });

        Schema::table('nilaipelajaran', function (Blueprint $table) {
            $table->string('semester_nama')->nullable();
        });
        Schema::table('nilaiekstrakulikuler', function (Blueprint $table) {
            $table->string('semester_nama')->nullable();
        });
        Schema::table('nilaikepribadian', function (Blueprint $table) {
            $table->string('semester_nama')->nullable();
        });
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
