<?php

namespace App\Http\Controllers;

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
