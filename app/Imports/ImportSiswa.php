<?php

namespace App\Imports;

use App\Models\siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSiswa implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function passdefaultsiswa(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultsiswa;
        return $data;
     
    }
    public function model(array $data)
    {
        $datasiswa=DB::table('siswa')->where('nis',$data['nis'])->count();
        $datasiswauser=DB::table('users')->where('nomerinduk',$data['nis'])->count();
        $pass=$this->passdefaultsiswa();
        if(!empty($data['pass'])){
            $pass=$data['pass'];
        }
        // dd($datasiswauser);
    if ($datasiswa<1) {

       DB::table('siswa')->insert(
        array(
                'nama' => $data['nama'],
                'nis' => $data['nis'], 
                'agama' => $data['agama'], 
                'tempatlahir' => $data['tempatlahir'], 
                'tgllahir' => $data['tgllahir'], 
                'alamat' => $data['alamat'], 
                'tapel_nama' => $data['tapel_nama'], 
                'kelas_nama' => $data['kelas_nama'], 
                'jk' => $data['jk'], 
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
                'moodleuser' => $data['moodleuser'], 
                'moodlepass' => $data['moodlepass'], 
        ));
        }else{

        siswa::where('nis',$data['nis'])
        ->update([
            'nama' => $data['nama'],
            'agama' => $data['agama'], 
            'tempatlahir' => $data['tempatlahir'], 
            'tgllahir' => $data['tgllahir'], 
            'alamat' => $data['alamat'], 
            'tapel_nama' => $data['tapel_nama'], 
            'kelas_nama' => $data['kelas_nama'], 
            'jk' => $data['jk'], 
            'created_at' => $data['created_at'], 
            'updated_at' => $data['updated_at'], 
            'moodleuser' => $data['moodleuser'], 
            'moodlepass' => $data['moodlepass'], 
        ]);

        }


    if ($datasiswauser<1) {
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $data['nis'],
               'name'     =>   $data['nama'],
               'password' => Hash::make($pass),
               'tipeuser'     =>   'siswa',
               'email'     =>   $data['email'],
               'created_at' => $data['created_at'], 
               'updated_at' => $data['updated_at'], 
        ));

        }else{
            if(!empty($data['pass'])){

                User::where('nomerinduk',$data['nis'])
                ->update([
                    'name'     =>   $data['nama'],
                    'email'     =>   $data['email'],
                    'password' => Hash::make($pass),
                    'updated_at' => $data['updated_at'], 
                ]);
            }else{
                
            User::where('nomerinduk',$data['nis'])
            ->update([
                'name'     =>   $data['nama'],
                'email'     =>   $data['email'],
                'updated_at' => $data['updated_at'], 
            ]);
        }

        } 
    }

        
}
