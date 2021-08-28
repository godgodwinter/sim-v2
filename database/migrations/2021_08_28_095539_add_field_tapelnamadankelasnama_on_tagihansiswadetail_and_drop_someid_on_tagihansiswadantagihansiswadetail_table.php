<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTapelnamadankelasnamaOnTagihansiswadetailAndDropSomeidOnTagihansiswadantagihansiswadetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('tagihansiswadetail', function (Blueprint $table) {
            $table->string('siswa_nis')->nullable();
            $table->string('siswa_nama')->nullable();
            $table->string('tapel_nama')->nullable();
            $table->string('kelas_nama')->nullable();
        });

        Schema::table('tagihansiswa', function($table) {
            $table->dropColumn('tagihanatur_kd');
         });

        Schema::table('tagihansiswadetail', function($table) {
            $table->dropColumn('tagihansiswa_id');
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
