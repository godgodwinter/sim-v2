<?php

namespace App\Imports;

use App\Models\banksoal;
use App\Models\banksoaljawaban;
use App\Models\inputnilai;
use App\Models\kko;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use App\Models\siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class importmateri implements ToCollection,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    protected $kompetensidasar;

    function __construct($kompetensidasar) {
           $this->kompetensidasar = $kompetensidasar;
    }

    public function collection(Collection $rows, $calculateFormulas = false)
    {
        ini_set('max_execution_time', 3000);
        // dd($rows);
    $no=0;
    foreach($rows as $row){
    if($no>0){
        $cekdatas=materipokok::where('kompetensidasar_id',$this->kompetensidasar->id)->where('nama',$row[1])
        ->count();
        if($cekdatas>0){
            //update

        }else{
            $datas_id=materipokok::insertGetId(
                array(
                        'nama'     =>   $row[1],
                        'link'     =>   $row[2],
                        'kompetensidasar_id'     =>   $this->kompetensidasar->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));


    }
    }
    // dd($no);
    $no++;
    }
}
}
