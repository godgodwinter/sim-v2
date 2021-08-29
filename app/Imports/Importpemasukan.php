<?php

namespace App\Imports;

use App\Models\pemasukan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Importpemasukan implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function model(array $data)
    {
        $datas=DB::table('pemasukan')
        ->where('nama',$data['nama'])
        ->where('tglbayar',$data['tglbayar'])
        ->where('kategori_nama',$data['kategori_nama'])
        ->count();
        // $isnumber=is_numeric($var_num);
        $nominal=100;
        if(is_numeric($data['nominal'])){
            $nominal=$data['nominal'];
        }
    
    if ($datas<1) {

       DB::table('pemasukan')->insert(
        array(
                'nama' => $data['nama'],
                'tglbayar' => $data['tglbayar'], 
                'kategori_nama' => $data['kategori_nama'], 
                'catatan' => $data['catatan'], 
                'nominal' => $nominal, 
                'created_at' => $data['created_at'], 
                'updated_at' => $data['updated_at'], 
        ));
        }else{

        pemasukan::where('nama',$data['nama'])
        ->where('tglbayar',$data['tglbayar'])
        ->where('kategori_nama',$data['kategori_nama'])
        ->update([
            'catatan' => $data['catatan'], 
            'nominal' => $nominal, 
            'created_at' => $data['created_at'], 
            'updated_at' => $data['updated_at'], 
        ]);

        }



         
    }

        
}
