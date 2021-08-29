<?php

namespace App\Imports;

use App\Models\tagihansiswadetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importtagihansiswadetail implements ToModel, WithHeadingRow
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
        $datas=DB::table('tagihansiswadetail')
        ->where('siswa_nis',$data['siswa_nis'])
        ->where('kelas_nama',$data['kelas_nama'])
        ->where('tapel_nama',$data['tapel_nama'])
        ->where('created_at',$data['created_at'])
        ->count();
        // $isnumber=is_numeric($var_num);
        $nominal=0;
        if(is_numeric($data['nominal'])){
            $nominal=$data['nominal'];
        }
    
    if ($datas<1) {

       DB::table('tagihansiswadetail')->insert(
        array(
                'siswa_nis' => $data['siswa_nis'],
                'siswa_nama' => $data['siswa_nama'],
                'kelas_nama' => $data['kelas_nama'],
                'tapel_nama' => $data['tapel_nama'], 
                'nominal' => $nominal, 
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        tagihansiswadetail::where('kelas_nama',$data['kelas_nama'])
        ->where('siswa_nis',$data['siswa_nis'])
        ->where('tapel_nama',$data['tapel_nama'])
        ->where('created_at',$data['created_at'])
        ->update([
            'siswa_nama' => $data['siswa_nama'],
            'nominal' => $nominal, 
            'updated_at' => $data['updated_at'], 
        ]);

        }



         
    }

        
}
