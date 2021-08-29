<?php

namespace App\Imports;

use App\Models\pegawai;
use App\Models\tapel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importtapel implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function model(array $data)
    {
        $datas=DB::table('tapel')
        ->where('nama',$data['nama'])
        ->count();
    
    if ($datas<1) {

       DB::table('tapel')->insert(
        array(
                'nama' => $data['nama'],
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        // tapel::where('nama',$data['nama'])
        // ->where('tapel_nama',$data['tapel_nama'])
        // ->update([
        //     'nominaltagihan' => $nominal, 
        //     'created_at' => $data['created_at'], 
        //     'updated_at' => $data['updated_at'], 
        // ]);

        }



         
    }

        
}
