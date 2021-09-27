<?php

namespace App\Imports;

use App\Models\kko;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class importkko implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function model(array $data)
    {
        $datas=DB::table('kko')
        ->where('nama',$data['nama'])
        ->count();

    if ($datas<1) {

       DB::table('kko')->insert(
        array(
                'nama' => $data['nama'],
                'tipe' => $data['tipe'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
        ));
        }else{

        kko::where('nama',$data['nama'])
        ->update([
            'nama' => $data['nama'],
            'tipe' => $data['tipe'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ]);

        }




    }


}
