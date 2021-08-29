<?php

namespace App\Imports;

use App\Models\tagihanatur;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importtagihanatur implements ToModel, WithHeadingRow
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
        $datas=DB::table('tagihanatur')
        ->where('kelas_nama',$data['kelas_nama'])
        ->where('tapel_nama',$data['tapel_nama'])
        ->count();
        // $isnumber=is_numeric($var_num);
        $nominal=$this->nominaltagihandefault();
        if(is_numeric($data['nominaltagihan'])){
            $nominal=$data['nominaltagihan'];
        }
    
    if ($datas<1) {

       DB::table('tagihanatur')->insert(
        array(
                'kelas_nama' => $data['kelas_nama'],
                'tapel_nama' => $data['tapel_nama'], 
                'nominaltagihan' => $nominal, 
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        tagihanatur::where('kelas_nama',$data['kelas_nama'])
        ->where('tapel_nama',$data['tapel_nama'])
        ->update([
            'nominaltagihan' => $nominal, 
            'created_at' => $data['created_at'], 
            'updated_at' => $data['updated_at'], 
        ]);

        }



         
    }

        
}
