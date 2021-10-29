<?php

namespace App\Imports;

use App\Models\inputnilai;
use App\Models\kko;
use App\Models\siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class importnilaipermateri implements ToCollection,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    protected $dataajar;
    protected $materipokok;

    function __construct($dataajar,$materipokok) {
           $this->dataajar = $dataajar;
           $this->materipokok = $materipokok;
    }

    public function collection(Collection $rows, $calculateFormulas = false)
    {
        // $rows->calculate(false);
        ini_set('max_execution_time', 3000);
        $sekolah_id=$this->id;
        // DB::table('sekolah')->insert(
        //     array(
        //         'nama'     =>  'test123',
        //         'alamat'     =>  'zzz',
        //         'status'     =>  'aaa',
        //         'deleted_at' => null,
        //     ));
        // dd($rows);
    $no=0;
    foreach($rows as $row){
    if($no>0){

    $ceksiswa=siswa::where('nomerinduk',$row[0])->count();
    if($ceksiswa>0){

    $siswa_id=siswa::where('nomerinduk',$row[0])->get('id');
    dd($siswa_id);
    }

    }
    }
}
}
