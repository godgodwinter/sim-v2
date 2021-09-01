<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class oneseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //ADMIN SEEDER
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$oOhE/tcF8MC9crGCw/Zv5.zFMGu0JLm591undChCaHJM6YrnGjgCu',
            'tipeuser' => 'admin',
            'nomerinduk' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        //KEPSEK SEEDER
        DB::table('users')->insert([
            'name' => 'Kepsek',
            'email' => 'kepsek@gmail.com',
            'password' => '$2y$10$oOhE/tcF8MC9crGCw/Zv5.zFMGu0JLm591undChCaHJM6YrnGjgCu',
            'tipeuser' => 'kepsek',
            'nomerinduk' => '111',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        //Siswa SEEDER
        DB::table('users')->insert([
            'name' => 'Paijo',
            'email' => 'siswa@gmail.com',
            'password' => '$2y$10$oOhE/tcF8MC9crGCw/Zv5.zFMGu0JLm591undChCaHJM6YrnGjgCu',
            'tipeuser' => 'siswa',
            'nomerinduk' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        //Siswa SEEDER
        DB::table('siswa')->insert([
            'nama' => 'Paijo',
            'tapel_nama' => '2021/2022',
            'kelas_nama' => 'XI OTO 1',
            'tempatlahir' => 'Malang',
            'tgllahir' => '2003-05-20',
            'alamat' => 'Desa Sumbersari Kecamatan Losari Kabupaten Trenggalek',
            'nis' => '1',
            'jk' => 'Laki-laki',
            'moodleuser' => 'p41j0',
            'moodlepass' => 'b4qweRty',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);



        //KATEGORI SEEDER
        //pegawai
        DB::table('kategori')->insert([
            'nama' => 'Kepala Sekolah',
            'prefix' => 'pegawai',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('kategori')->insert([
             'nama' => 'pelajaran',
             'prefix' => 'pelajaran',
             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now()
          ]);

          DB::table('kategori')->insert([
              'nama' => 'mulok',
              'prefix' => 'pelajaran',
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now()
           ]);

        DB::table('kategori')->insert([
            'nama' => 'Administrator/Bendahara',
            'prefix' => 'pegawai',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //pemasukan
        DB::table('kategori')->insert([
            'nama' => 'Dana Bos',
            'prefix' => 'pemasukan',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        DB::table('kategori')->insert([
            'nama' => 'Lain-lain',
            'prefix' => 'pemasukan',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


         //pengeluaran
        DB::table('kategori')->insert([
            'nama' => 'Dana Bulanan',
            'prefix' => 'pengeluaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //pengeluaran
        DB::table('kategori')->insert([
            'nama' => 'Lain-lain',
            'prefix' => 'pengeluaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //TAPEL SEEDER
        DB::table('tapel')->insert([
            'nama' => '2021/2022',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


         //KELAS SEEDER
        DB::table('kelas')->insert([
            'nama' => 'X OTO 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


         //KELAS SEEDER
        DB::table('kelas')->insert([
            'nama' => 'X TKJ 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //KELAS SEEDER
        DB::table('kelas')->insert([
            'nama' => 'XI OTO 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //KELAS SEEDER
        DB::table('kelas')->insert([
            'nama' => 'XI TKJ 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

              //KELAS SEEDER
        DB::table('kelas')->insert([
            'nama' => 'XII OTO 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

              //KELAS SEEDER
        DB::table('kelas')->insert([
            'nama' => 'XII TKJ 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


         //KELAS SEEDER
        DB::table('pegawai')->insert([
            'nig' => '123',
            'nama' => 'Admin',
            'kategori_nama' => 'Administrator/Bendahara',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


         //KELAS SEEDER
        DB::table('pegawai')->insert([
            'nig' => '111',
            'nama' => 'Kepala Sekolah',
            'kategori_nama' => 'Kepala Sekolah',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //settings SEEDER
        DB::table('settings')->insert([
            'paginationjml' => '10',
            'tapelaktif' => '2021/2022',
            'sekolahnama' => 'SMP ABCD 01 Malang',
            'sekolahalamat' => 'Jl. Abcd Desa Qwerty Kecamatan Zxcvb',
            'sekolahtelp' => '0341-123456',
            'aplikasijudul' => 'SIM SMK KROMENGAN',
            'aplikasijudulsingkat' => 'SIM',
            'nominaltagihandefault' => '1000000',
            'passdefaultsiswa' => 'siswa123',
            'passdefaultpegawai' => '12345678',
            'passdefaultortu' => 'ortu123',
            'sekolahlogo' => '',
            'sekolahttd' => 'Nama Kepala Sekolah M.Pd',
            'sekolahttd2' => 'Nama Kepala Sekolah M.Pd', //masih konsep
            'minimalpembayaranujian' => 70, //untuk melihat pass dan user moodle
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);



         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'UTS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'UAS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);
    }
}
