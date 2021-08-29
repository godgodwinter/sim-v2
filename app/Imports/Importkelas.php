<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importkelas implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function model(array $data)
    {
        $datas=DB::table('kelas')
        ->where('nama',$data['nama'])
        ->count();
    
    if ($datas<1) {

       DB::table('kelas')->insert(
        array(
                'nama' => $data['nama'],
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        // kelas::where('nama',$data['nama'])
        // ->where('kelas_nama',$data['kelas_nama'])
        // ->update([
        //     'nominaltagihan' => $nominal, 
        //     'created_at' => $data['created_at'], 
        //     'updated_at' => $data['updated_at'], 
        // ]);

        }



         
    }

        
}
