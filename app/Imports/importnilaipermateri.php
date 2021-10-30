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
    }

    public function collection(Collection $rows, $calculateFormulas = false)
    {
        // dd($rows,$this->materipokok->id);
        // $rows->calculate(false);
        ini_set('max_execution_time', 3000);
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
            $ambildatasiswa=siswa::where('nomerinduk',$row[0])->first();
            $siswa_id=$ambildatasiswa->id;
            $periksainputnilai=inputnilai::where('siswa_id',$siswa_id)->where('materipokok_id',$this->materipokok->id)->count();
            // dd($periksainputnilai);
            if($periksainputnilai>0){
                //update
                    inputnilai::where('siswa_id',$siswa_id)
                    ->where('materipokok_id',$this->materipokok->id)
                    ->update([
                        'nilai'     =>   $row[2],
                    'updated_at'=>date("Y-m-d H:i:s")
                    ]);
            }else{
                // insert
            DB::table('inputnilai')->insert(
                array(
                        'siswa_id'     =>   $siswa_id,
                        'materipokok_id'     =>   $this->materipokok->id,
                        'nilai'     =>   $row[2],
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));
            }
            // dd($siswa_id);
        }
    }
    // dd($no);
    $no++;
    }
}
}
