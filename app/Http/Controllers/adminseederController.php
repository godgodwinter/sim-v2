<?php

namespace App\Http\Controllers;

use App\Models\jenisnilai;
use App\Models\pelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class adminseederController extends Controller
{
    public function siswa(){

        $jmldata=20;
        $limitdata=200;
        // dd('seeder siswa');
        // 1. cek jika siswa diatas 100 maka kembali
        $ambiljmlsiswa=DB::table('siswa')->where('tapel_nama',$this->tapelaktif())
        ->count();
        if($ambiljmlsiswa>$limitdata){
            return redirect()->back()->with('status','Gagal! Data siswa lebih dari '.$limitdata)->with('tipe','danger')->with('icon','fas fa-trash');
        }
        // 2. looping 10(default) 
        for($i=0;$i<$jmldata;$i++){
        // 3. insert data siswa
            $faker = Faker::create('id_ID');

        $nama=$faker->name;
        $nis=date('YmdHis').$i;


            DB::table('siswa')->insert([
                'nama' => $nama,
                'tapel_nama' => $this->tapelaktif(),
                'kelas_nama' => $faker->randomElement(['X OTO 1', 'X TKJ 1','XI OTO 1', 'XI TKJ 1','XII OTO 1','XII TKJ 1']),
                'tempatlahir' => $faker->randomElement(['Sumbersari', 'Jakarta','Surabaya','Blitar']),
                'tgllahir' => $faker->numberBetween(1990,2020).'-0'.$faker->numberBetween(1,9).'-'.$faker->numberBetween(10,29),
                'alamat' => 'Desa '.$faker->randomElement(['Sumbersari', 'Sumbermakmur','Mulyorejo','Morodadi']).' Kecamatan Losari Kabupaten Malang',
                'nis' => $nis,
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'moodleuser' => 'p'.$faker->unique()->numberBetween(111,999).'a'.$faker->unique()->numberBetween(111,999),
                'moodlepass' => 'qW'.$faker->unique()->numberBetween(111,999).'K'.$faker->unique()->numberBetween(111,999),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            // dd($i);
        // 3. insert data usersiswa

            DB::table('users')->insert([
                'name' => $nama,
                'email' =>  $faker->email,
                'password' => Hash::make($this->passdefaultsiswa()),
                'tipeuser' => 'siswa',
                'nomerinduk' => $nis,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);



        }

        return redirect(URL::to('/').'/admin/datatagihan/addall')->with('status','Seeder berhasil di lakukan!')->with('tipe','success')->with('icon','fas fa-feather');


    }

    public function guru(){

        $jmldata=5;
        $limitdata=30;
        // dd('seeder siswa');
        // 1. cek jika siswa diatas 100 maka kembali
        $ambiljmldata=DB::table('guru')
        ->count();
        if($ambiljmldata>$limitdata){
            return redirect()->back()->with('status','Gagal! Data  lebih dari '.$limitdata)->with('tipe','danger')->with('icon','fas fa-trash');
        }
        // 2. looping 10(default) 
        for($i=0;$i<$jmldata;$i++){
        // 3. insert data siswa
            $faker = Faker::create('id_ID');

        $nama=$faker->name;
        $nomerinduk=date('YmdHis').$i;


            DB::table('guru')->insert([
                'nama' => $nama,
                'alamat' => 'Desa '.$faker->randomElement(['Sumbersari', 'Sumbermakmur','Mulyorejo','Morodadi']).' Kecamatan Losari Kabupaten Malang',
                'nomerinduk' => $nomerinduk,
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            // dd($i);
        // 3. insert data usersiswa

            DB::table('users')->insert([
                'name' => $nama,
                'email' =>  $faker->email,
                'password' => Hash::make($this->passdefaultpegawai()),
                'tipeuser' => 'guru',
                'nomerinduk' => $nomerinduk,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);



        }

        return redirect()->back()->with('status','Seeder berhasil di lakukan!')->with('tipe','success')->with('icon','fas fa-feather');


    }

    public function mapel(){

        pelajaran::truncate();

            DB::table('pelajaran')->insert([
                'nama' => 'Pendidikan Agama',
                'tipepelajaran' => 'A. Nilai Akademik',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Pendidikan Kewarganegaraan',
                'tipepelajaran' => 'A. Nilai Akademik',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Bahasa Indonesia',
                'tipepelajaran' => 'A. Nilai Akademik',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Matematika',
                'tipepelajaran' => 'A. Nilai Akademik',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Sejarah Indonesia',
                'tipepelajaran' => 'A. Nilai Akademik',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Bahasa Inggris dan Bahasa Asing lainnya',
                'tipepelajaran' => 'A. Nilai Akademik',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Seni Budaya',
                'tipepelajaran' => 'B. Muatan kewilayahan',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Pendidikan Jasmani Olah Raga dan Kesehatan',
                'tipepelajaran' => 'B. Muatan kewilayahan',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Mulok (Bahasa Jawa)',
                'tipepelajaran' => 'B. Muatan kewilayahan',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Kimia',
                'tipepelajaran' => 'C1. Dasar Bidang Keahlian',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Simulasi dan Komunikasi Digital',
                'tipepelajaran' => 'C1. Dasar Bidang Keahlian',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Fisika',
                'tipepelajaran' => 'C1. Dasar Bidang Keahlian',
                'jurusan' => 'semua',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Gambar Teknik Otomotif',
                'tipepelajaran' => 'C2. Dasar Program Keahlian',
                'jurusan' => 'OTO',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::table('pelajaran')->insert([
                'nama' => 'Teknologi Dasar Otomotif',
                'tipepelajaran' => 'C2. Dasar Program Keahlian',
                'jurusan' => 'OTO',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::table('pelajaran')->insert([
                'nama' => 'Pekerjaan Dasar Teknik Otomotif',
                'tipepelajaran' => 'C2. Dasar Program Keahlian',
                'jurusan' => 'OTO',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            DB::table('pelajaran')->insert([
                'nama' => 'Pemrograman 1',
                'tipepelajaran' => 'C2. Dasar Program Keahlian',
                'jurusan' => 'TKJ',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('pelajaran')->insert([
                'nama' => 'Pemrograman 2',
                'tipepelajaran' => 'C2. Dasar Program Keahlian',
                'jurusan' => 'TKJ',
                'kkm' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return redirect()->back()->with('status','Seeder berhasil di lakukan!')->with('tipe','success')->with('icon','fas fa-feather');


    }

    public function jenisnilai(){

        jenisnilai::truncate();

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas 1',
                'tipe' => 'Pengetahuan',
                'kode' => 'T1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas 2',
                'tipe' => 'Pengetahuan',
                'kode' => 'T2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas 3',
                'tipe' => 'Pengetahuan',
                'kode' => 'T3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas 4',
                'tipe' => 'Pengetahuan',
                'kode' => 'T4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas 5',
                'tipe' => 'Pengetahuan',
                'kode' => 'T5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Ujian Tengah Semester',
                'tipe' => 'Pengetahuan',
                'kode' => 'UTS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Ujian Akhir Semester',
                'tipe' => 'Pengetahuan',
                'kode' => 'UAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Setelah UTS',
                'tipe' => 'Ketrampilan',
                'kode' => 'KUTS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas Ketrampilan 1',
                'tipe' => 'Ketrampilan',
                'kode' => 'KT1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('jenisnilai')->insert([
                'nama' => 'Tugas Ketrampilan 2',
                'tipe' => 'Ketrampilan',
                'kode' => 'KT2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);


            return redirect()->back()->with('status','Seeder berhasil di lakukan!')->with('tipe','success')->with('icon','fas fa-feather');
    
        }

    public function kelas(){
        // dd('seeder kelas');

        $ambildata=DB::table('kelas')->where('nama','X OTO 1')
        ->count();
        if($ambildata<1){
            DB::table('kelas')->insert([
                'nama' => 'X OTO 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }


        $ambildata=DB::table('kelas')->where('nama','X TKJ 1')
        ->count();
        if($ambildata<1){
            DB::table('kelas')->insert([
                'nama' => 'X TKJ 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }



        $ambildata=DB::table('kelas')->where('nama','XI OTO 1')
        ->count();
        if($ambildata<1){
            DB::table('kelas')->insert([
                'nama' => 'XI OTO 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }

        $ambildata=DB::table('kelas')->where('nama','XI TKJ 1')
        ->count();
        if($ambildata<1){
            DB::table('kelas')->insert([
                'nama' => 'XI TKJ 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }


        $ambildata=DB::table('kelas')->where('nama','XII OTO 1')
        ->count();
        if($ambildata<1){
            DB::table('kelas')->insert([
                'nama' => 'XII OTO 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }



        $ambildata=DB::table('kelas')->where('nama','XII TKJ 1')
        ->count();
        if($ambildata<1){
            DB::table('kelas')->insert([
                'nama' => 'XII TKJ 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }

        return redirect(URL::to('/').'/admin/datatagihan/addall')->with('status','Seeder berhasil di lakukan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
