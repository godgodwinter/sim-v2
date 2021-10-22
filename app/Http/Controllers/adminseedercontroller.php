<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\kelas;
use App\Models\mapel;
use App\Models\siswa;
use App\Models\tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class adminseedercontroller extends Controller
{
    public function kelas(Request $request){
        kelas::truncate();

         //KELAS SEEDER
         DB::table('kelas')->insert([
            'tingkatan' => 'X',
            'jurusan' => 'OTO',
            'suffix' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


         //KELAS SEEDER
        DB::table('kelas')->insert([
            'tingkatan' => 'X',
            'jurusan' => 'TKJ',
            'suffix' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //KELAS SEEDER
        DB::table('kelas')->insert([
            'tingkatan' => 'XI',
            'jurusan' => 'OTO',
            'suffix' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

         //KELAS SEEDER
        DB::table('kelas')->insert([
            'tingkatan' => 'XI',
            'jurusan' => 'TKJ',
            'suffix' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

              //KELAS SEEDER
        DB::table('kelas')->insert([
            'tingkatan' => 'XII',
            'jurusan' => 'OTO',
            'suffix' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);

              //KELAS SEEDER
        DB::table('kelas')->insert([
            'tingkatan' => 'XII',
            'jurusan' => 'TKJ',
            'suffix' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);
        //  DB::table('kelas')->insert([
        //     'nama' => 'X OTO 1',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        //  ]);
        // DB::table('kelas')->insert([
        //     'nama' => 'X TKJ 1',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        //  ]);
        // DB::table('kelas')->insert([
        //     'nama' => 'XI OTO 1',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        //  ]);
        // DB::table('kelas')->insert([
        //     'nama' => 'XI TKJ 1',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        //  ]);
        // DB::table('kelas')->insert([
        //     'nama' => 'XII OTO 1',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        //  ]);
        // DB::table('kelas')->insert([
        //     'nama' => 'XII TKJ 1',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        //  ]);
    return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function siswa(Request $request){
        // dd('seeder');
        $jmlseeder=30;
        // 1. insert data sekolah
        $faker = Faker::create('id_ID');
        $pre=$faker->randomElement(['SMPN','SMAN']);
        $num=$faker->numberBetween(1,20);
        $city=$faker->unique()->city;

        // 4. input walikelas, kelas,  pengguna referensi , bidang studi , siswa

        for($i=0;$i<$jmlseeder;$i++){
            // 3. insert data siswa

            $sekolah=$pre.' '.$num.' '.$city;
            $nama=$faker->unique()->name;
            $nomerinduk=$faker->unique()->ean8;
            DB::table('users')->insert([
                'name' =>  $nama,
                'email' => $faker->unique()->email,
                'username'=>date('YmdHid').$i,
                'nomerinduk'=>$nomerinduk,
                'password' => Hash::make('123'),
                'tipeuser' => 'siswa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $gettapel=DB::table('tapel')->pluck('id');
            $getkelas=DB::table('kelas')->pluck('id');

            $getusers_id=DB::table('users')->orderBy('id','desc')->first();
            // dd($faker->randomElement($getkelas));


            DB::table('siswa')->insert([
                'nama' => $nama,
                'agama' => $faker->randomElement(['Islam', 'Hindu','Kristen']),
                'nomerinduk' => $nomerinduk,
                'users_id' => $getusers_id->id,
                'tapel_id' => $faker->randomElement($gettapel),
                'kelas_id' =>$faker->randomElement($getkelas),
                'tempatlahir' => $city,
                'tgllahir' => $faker->numberBetween(1990,2020).'-0'.$faker->numberBetween(1,9).'-'.$faker->numberBetween(10,29),
                'alamat' => $faker->unique()->address,
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'moodleuser' => 'p'.$faker->unique()->numberBetween(111,999).'a'.$faker->unique()->numberBetween(111,999),
                'moodlepass' => 'qW'.$faker->unique()->numberBetween(111,999).'K'.$faker->unique()->numberBetween(111,999),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);



     }



        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');

    }
    public function hard(Request $request){
        siswa::truncate();
        guru::truncate();
        kelas::truncate();
        tapel::truncate();
        mapel::truncate();
        DB::table('users')->where('tipeuser','siswa')->delete();
        DB::table('users')->where('tipeuser','guru')->delete();
        return redirect()->back()->with('status','Hard Reset berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');

    }

    public function guru(Request $request){
        // dd('seeder');
        $jmlseeder=10;
        // 1. insert data sekolah
        $faker = Faker::create('id_ID');
        $pre=$faker->randomElement(['SMPN','SMAN']);
        $num=$faker->numberBetween(1,20);
        $city=$faker->unique()->city;

        // 4. input walikelas, kelas,  pengguna referensi , bidang studi , siswa

        for($i=0;$i<$jmlseeder;$i++){
            // 3. insert data siswa

            $sekolah=$pre.' '.$num.' '.$city;
            $nama=$faker->unique()->name;
            $nomerinduk=$faker->unique()->ean8;
            DB::table('users')->insert([
                'name' =>  $nama,
                'email' => $faker->unique()->email,
                'username'=>date('YmdHid').$i,
                'nomerinduk'=>$nomerinduk,
                'password' => Hash::make('123'),
                'tipeuser' => 'guru',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $getusers_id=DB::table('users')->orderBy('id','desc')->first();
            // dd($faker->randomElement($getkelas));


            DB::table('guru')->insert([
                'nama' => $nama,
                'nomerinduk' => $nomerinduk,
                'users_id' => $getusers_id->id,
                'telp' => $faker->phoneNumber(),
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'alamat' => $faker->unique()->address,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

    }
    return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');

}
public function mapel(Request $request){


    mapel::truncate();

    DB::table('mapel')->insert([
        'nama' => 'Pendidikan Agama',
        'tipepelajaran' => 'A. Nilai Akademik',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Pendidikan Kewarganegaraan',
        'tipepelajaran' => 'A. Nilai Akademik',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Bahasa Indonesia',
        'tipepelajaran' => 'A. Nilai Akademik',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Matematika',
        'tipepelajaran' => 'A. Nilai Akademik',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Sejarah Indonesia',
        'tipepelajaran' => 'A. Nilai Akademik',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Bahasa Inggris dan Bahasa Asing lainnya',
        'tipepelajaran' => 'A. Nilai Akademik',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Seni Budaya',
        'tipepelajaran' => 'B. Muatan kewilayahan',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Pendidikan Jasmani Olah Raga dan Kesehatan',
        'tipepelajaran' => 'B. Muatan kewilayahan',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Mulok (Bahasa Jawa)',
        'tipepelajaran' => 'B. Muatan kewilayahan',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);


    DB::table('mapel')->insert([
        'nama' => 'Simulasi dan Komunikasi Digital',
        'tipepelajaran' => 'C1. Dasar Bidang Keahlian',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Fisika',
        'tipepelajaran' => 'C1. Dasar Bidang Keahlian',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Kimia',
        'tipepelajaran' => 'C1. Dasar Bidang Keahlian',
        'jurusan' => 'semua',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Gambar Teknik Otomotif',
        'tipepelajaran' => 'C2. Dasar Program Keahlian',
        'jurusan' => 'OTO',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Teknologi Dasar Otomotif',
        'tipepelajaran' => 'C2. Dasar Program Keahlian',
        'jurusan' => 'OTO',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Pekerjaan Dasar Teknik Otomotif',
        'tipepelajaran' => 'C2. Dasar Program Keahlian',
        'jurusan' => 'OTO',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Pemrograman 1',
        'tipepelajaran' => 'C2. Dasar Program Keahlian',
        'jurusan' => 'TKJ',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    DB::table('mapel')->insert([
        'nama' => 'Pemrograman 2',
        'tipepelajaran' => 'C2. Dasar Program Keahlian',
        'jurusan' => 'TKJ',
        'kkm' => '75',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');


}
}
