<?php

namespace App\Imports;

use App\Models\tagihansiswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importtagihansiswa implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function nominaltagihandefault(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->nominaltagihandefault;
        return $data;
     
    }
    public function model(array $data)
    {
        $datas=DB::table('tagihansiswa')
        ->where('siswa_nis',$data['siswa_nis'])
        ->where('kelas_nama',$data['kelas_nama'])
        ->where('tapel_nama',$data['tapel_nama'])
        ->count();
        // $isnumber=is_numeric($var_num);
        $nominal=$this->nominaltagihandefault();
        if(is_numeric($data['nominaltagihan'])){
            $nominal=$data['nominaltagihan'];
        }
    
    if ($datas<1) {

       DB::table('tagihansiswa')->insert(
        array(
                'siswa_nis' => $data['siswa_nis'],
                'siswa_nama' => $data['siswa_nama'],
                'kelas_nama' => $data['kelas_nama'],
                'tapel_nama' => $data['tapel_nama'], 
                'nominaltagihan' => $nominal, 
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        tagihansiswa::where('kelas_nama',$data['kelas_nama'])
        ->where('siswa_nis',$data['siswa_nis'])
        ->where('tapel_nama',$data['tapel_nama'])
        ->update([
            'siswa_nama' => $data['siswa_nama'],
            'nominaltagihan' => $nominal, 
            'created_at' => $data['created_at'], 
            'updated_at' => $data['updated_at'], 
        ]);

        }



         
    }

        
}
