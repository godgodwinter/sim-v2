<?php

namespace App\Imports;

use App\Models\banksoal;
use App\Models\banksoaljawaban;
use App\Models\inputnilai;
use App\Models\kko;
use App\Models\kompetensidasar;
use App\Models\siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class importkd implements ToCollection,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    protected $dataajar;

    function __construct($dataajar) {
           $this->dataajar = $dataajar;
    }
    public function ambilkode($kode)
    {
        $hasil=1;
        $string = str_replace(' ', '', $kode);
        $strex=explode(".",$string);
        if(count($strex)>1){
            $hasil=$strex[1];
        }else{
            $hasil=$strex[0];
        }
        return $hasil;
    }

    public function collection(Collection $rows, $calculateFormulas = false)
    {
        ini_set('max_execution_time', 3000);
        // dd($rows);
    $no=0;
    foreach($rows as $row){
    if($no>0){

     $tipe='1';
     if($row[2]=='Ketrampilan'){
         $tipe='2';
     }else{
         $tipe='1';
     }
        $cekdatas=kompetensidasar::where('dataajar_id',$this->dataajar->id)
        ->where('tipe',$tipe)
        ->where('nama',$row[1])
        ->count();
        if($cekdatas>0){
            //update

        }else{
            $datas_id=kompetensidasar::insertGetId(
                array(
                        'nama'     =>   $row[1],
                        'tipe'     =>   $tipe,
                        'kode'     =>   $this->ambilkode($row[3]),
                        'dataajar_id' => $this->dataajar->id,
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
