<?php

namespace App\Imports;

use App\Models\pegawai;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importpegawai implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function passdefaultpegawai(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultpegawai;
        return $data;
     
    }
    public function model(array $data)
    {
        $datapegawai=DB::table('pegawai')->where('nig',$data['nig'])->count();
        $datapegawaiuser=DB::table('users')->where('nomerinduk',$data['nig'])->count();
        $pass=$this->passdefaultpegawai();
        if(!empty($data['pass'])){
            $pass=$data['pass'];
        }
        $tipeuser='admin';
        if($data['kategori_nama']==='Administrator/Bendahara'){
            $tipeuser='admin';
        }else{
            $tipeuser='kepsek';
        }
        // dd($datapegawaiuser);
    if ($datapegawai<1) {

       DB::table('pegawai')->insert(
        array(
                'nama' => $data['nama'],
                'nig' => $data['nig'], 
                'kategori_nama' => $data['kategori_nama'], 
                'alamat' => $data['alamat'], 
                'telp' => $data['telp'], 
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        pegawai::where('nig',$data['nig'])
        ->update([
            'nama' => $data['nama'],
            'nig' => $data['nig'], 
            'kategori_nama' => $data['kategori_nama'], 
            'alamat' => $data['alamat'], 
            'telp' => $data['telp'], 
            'created_at' => $data['created_at'], 
            'updated_at' => $data['updated_at'], 
        ]);

        }


    if ($datapegawaiuser<1) {
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $data['nig'],
               'name'     =>   $data['nama'],
               'password' => Hash::make($pass),
               'tipeuser'     =>   $tipeuser,
               'email'     =>   $data['email'],
               'created_at' => $data['created_at'], 
               'updated_at' => $data['updated_at'], 
        ));

        }else{
            if(!empty($data['pass'])){

                User::where('nomerinduk',$data['nig'])
                ->update([
                    'name'     =>   $data['nama'],
                    'tipeuser'     =>   $tipeuser,
                    'email'     =>   $data['email'],
                    'password' => Hash::make($pass),
                    'updated_at' => $data['updated_at'], 
                ]);
            }else{
                
            User::where('nomerinduk',$data['nig'])
            ->update([
                'name'     =>   $data['nama'],
                'tipeuser'     =>   $tipeuser,
                'email'     =>   $data['email'],
                'updated_at' => $data['updated_at'], 
            ]);
        }

        } 
    }

        
}
