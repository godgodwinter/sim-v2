<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('admin'),
            'tipeuser' => 'admin',
            'nomerinduk' => '123',
            'username' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        //KEPSEK SEEDER
        DB::table('users')->insert([
            'name' => 'Kepsek',
            'email' => 'kepsek@gmail.com',
            'password' => Hash::make('kepsek'),
            'tipeuser' => 'kepsek',
            'username' => 'kepsek',
            'nomerinduk' => '111',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        //Siswa SEEDER
        DB::table('users')->insert([
            'name' => 'Paijo',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('siswa123'),
            'tipeuser' => 'siswa',
            'username' => 'siswa',
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
            'semesteraktif' => 1, //semesteraktif
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);



         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 1',
            'kode' => 'T1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 2',
            'kode' => 'T2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 3',
            'kode' => 'T3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 4',
            'kode' => 'T4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'Tugas 5',
            'kode' => 'T5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'UTS',
            'kode' => 'UTS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('jenisnilai')->insert([
            'nama' => 'UAS',
            'kode' => 'UAS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //kategori jurusan
        DB::table('kategori')->insert([
         'nama' => 'Otomotif',
         'kode' => 'OTO',
         'prefix' => 'jurusan',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now()
      ]);

         //kategori semester
         DB::table('kategori')->insert([
            'nama' => '1',
            'kode' => 'SATU',
            'prefix' => 'semester',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //kategori semester
         DB::table('kategori')->insert([
            'nama' => '2',
            'kode' => 'DUA',
            'prefix' => 'semester',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

      DB::table('kategori')->insert([
         'nama' => 'Teknik Jaringan dan Komputer',
         'kode' => 'TKJ',
         'prefix' => 'jurusan',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now()
      ]);

         //kategori tipepelajaran
         DB::table('kategori')->insert([
            'nama' => 'A. Muatan Nasional',
            'kode' => 'A',
            'prefix' => 'tipepelajaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('kategori')->insert([
            'nama' => 'B. Muatan kewilayahan',
            'kode' => 'B',
            'prefix' => 'tipepelajaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('kategori')->insert([
            'nama' => 'C1. Dasar Bidang Keahlian',
            'kode' => 'C1',
            'prefix' => 'tipepelajaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('kategori')->insert([
            'nama' => 'C2. Dasar Program Keahlian',
            'kode' => 'C2',
            'prefix' => 'tipepelajaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         DB::table('kategori')->insert([
            'nama' => 'C3. Kompetensi Keahlian',
            'kode' => 'C3',
            'prefix' => 'tipepelajaran',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);



        //kko
        DB::table('kko')->insert([
            'nama' => 'pengetahuan',
            'tipe' => 'C1',
            'tipe' => 'mudah',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'mengutip',
            'tipe' => 'C1',
            'tipe' => 'mudah',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menyebutkan',
            'tipe' => 'C1',
            'tipe' => 'mudah',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menjalaskan',
            'tipe' => 'C1',
            'tipe' => 'mudah',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menggambar',
            'tipe' => 'C1',
            'tipe' => 'mudah',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


        //kko
        DB::table('kko')->insert([
            'nama' => 'menugaskan',
            'tipe' => 'C3',
            'tipe' => 'sedang',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'mengurutkan',
            'tipe' => 'C3',
            'tipe' => 'sedang',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menentukan',
            'tipe' => 'C3',
            'tipe' => 'sedang',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menerapkan',
            'tipe' => 'C3',
            'tipe' => 'sedang',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menyesuaikan',
            'tipe' => 'C3',
            'tipe' => 'sedang',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);



        //kko
        DB::table('kko')->insert([
            'nama' => 'mengatur',
            'tipe' => 'C5',
            'tipe' => 'sulit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'mengabstraksi',
            'tipe' => 'C5',
            'tipe' => 'sulit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'menganimasikan',
            'tipe' => 'C5',
            'tipe' => 'sulit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'mengumpulkan',
            'tipe' => 'C5',
            'tipe' => 'sulit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

        DB::table('kko')->insert([
            'nama' => 'mengkategorikan',
            'tipe' => 'C5',
            'tipe' => 'sulit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);
    }
}
