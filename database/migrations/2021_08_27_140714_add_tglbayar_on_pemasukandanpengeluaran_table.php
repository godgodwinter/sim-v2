<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglbayarOnPemasukandanpengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->string('tglbayar')->nullable();
        });

        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->string('tglbayar')->nullable();
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
