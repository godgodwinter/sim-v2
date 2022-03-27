<?php

namespace App\Imports;

use App\Models\banksoal;
use App\Models\banksoaljawaban;
use App\Models\inputnilai;
use App\Models\kko;
use App\Models\siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class importbanksoal implements ToCollection,WithCalculatedFormulas
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

    public function carinilai($kategorisoal_nama,$hasil){
        if(($kategorisoal_nama==1) && ($hasil=='Benar')){
                $data=100;
        }elseif(($kategorisoal_nama==2) && ($hasil=='Benar')){
                $data=50;
        }elseif(($kategorisoal_nama==3) && ($hasil=='Benar')){
                $data=100;
        }else{
            $data=0;
        }
        return $data;
    }

    public function collection(Collection $rows, $calculateFormulas = false)
    {
        ini_set('max_execution_time', 3000);
        // dd($rows);
    $no=0;
    foreach($rows as $row){
    if($no>0){

     $tipe='1';
     if($row[2]=='Pilihan Ganda'){
         $tipe='1';
     }elseif($row[2]=='Pilihan Ganda'){
         $tipe='2';
     }else{
         $tipe='3';
     }

    //  $nilai=$this->carinilai($tipe,$row[6]);
    //  dd($row[6],$nilai);
        $cekbanksoal=banksoal::where('dataajar_id',$this->dataajar->id)
        ->where('pertanyaan',$row[1])
        ->where('kategorisoal_nama',$tipe)
        ->count();
        if($cekbanksoal>0){
            $ambilbanksoal=banksoal::where('dataajar_id',$this->dataajar->id)
            ->where('pertanyaan',$row[1])
            ->where('kategorisoal_nama',$tipe)->first();
            $banksoal_id=$ambilbanksoal->id;

                //update
                banksoal::where('dataajar_id',$this->dataajar->id)
                    ->where('pertanyaan',$row[1])
                    ->where('kategorisoal_nama',$tipe)
                    ->update([
                        'tingkatkesulitan'     =>   $row[3],
                        'gambar'     =>   $row[4],
                    'updated_at'=>date("Y-m-d H:i:s")
                    ]);

            //hapus semua jawaban where this id  kemudian insert jawaban
            banksoaljawaban::where('banksoal_id',$banksoal_id)->delete();
     // insert
            $collection = new Collection();
            if($tipe==3){
                    // dd($request);
                    if($row[6]=='Benar'){
                        $collection->push((object)['jawaban' => 'Benar',
                                                   'hasil'=> 'Benar',
                        ]);

                        $collection->push((object)['jawaban' => 'Salah',
                                                   'hasil'=> 'Salah',
                        ]);

                    }else{
                        $collection->push((object)['jawaban' => 'Benar',
                                                   'hasil'=> 'Salah',
                        ]);

                        $collection->push((object)['jawaban' => 'Salah',
                                                   'hasil'=> 'Benar',
                        ]);

                    }
            }else{
                if($row[5]!=null){
                    $collection->push((object)['jawaban' => $row[5],
                                               'hasil'=>$row[6],
                    ]);
                }
                if($row[7]!=null){
                    $collection->push((object)['jawaban' => $row[7],
                                               'hasil'=>$row[8],
                    ]);
                }
                if($row[9]!=null){
                    $collection->push((object)['jawaban' => $row[9],
                                               'hasil'=>$row[10],
                    ]);
                }
                if($row[11]!=null){
                    $collection->push((object)['jawaban' => $row[11],
                                               'hasil'=>$row[12],
                    ]);
                }
                if($row[13]!=null){
                    $collection->push((object)['jawaban' => $row[13],
                                               'hasil'=>$row[14],
                    ]);
                }
            }

        foreach($collection as $j){
            $nilai=$this->carinilai($tipe,$j->hasil);
            // dd($nilai);
            DB::table('banksoaljawaban')->insert(
            array(
                'jawaban'     =>   $j->jawaban,
                'hasil'     =>   $j->hasil,
                'nilai'     =>   $nilai,
                'banksoal_id'     =>   $banksoal_id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ));

        }

            // dd($siswa_id);
        }else{
            $nilai=$this->carinilai($tipe,$row[6]);
            $banksoal_id=banksoal::insertGetId(
                array(
                        'pertanyaan'     =>   $row[1],
                        'kategorisoal_nama'     =>   $tipe,
                        'tingkatkesulitan'     =>   $row[3],
                        'gambar'     =>   $row[4],
                        'dataajar_id'     =>   $this->dataajar->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));
            // $banksoal_id=$banksoallast->id;
// dd($banksoal_id);
            //hapus semua jawaban where this id  kemudian insert jawaban
            banksoaljawaban::where('banksoal_id',$banksoal_id)->delete();

            $collection = new Collection();
            if($tipe==3){
                    // dd($request);
                    if($row[6]=='Benar'){
                        $collection->push((object)['jawaban' => 'Benar',
                                                   'hasil'=> 'Benar',
                        ]);

                        $collection->push((object)['jawaban' => 'Salah',
                                                   'hasil'=> 'Salah',
                        ]);

                    }else{
                        $collection->push((object)['jawaban' => 'Benar',
                                                   'hasil'=> 'Salah',
                        ]);

                        $collection->push((object)['jawaban' => 'Salah',
                                                   'hasil'=> 'Benar',
                        ]);

                    }
            }else{
                if($row[5]!=null){
                    $collection->push((object)['jawaban' => $row[5],
                                               'hasil'=>$row[6],
                    ]);
                }
                if($row[7]!=null){
                    $collection->push((object)['jawaban' => $row[7],
                                               'hasil'=>$row[8],
                    ]);
                }
                if($row[9]!=null){
                    $collection->push((object)['jawaban' => $row[9],
                                               'hasil'=>$row[10],
                    ]);
                }
                if($row[11]!=null){
                    $collection->push((object)['jawaban' => $row[11],
                                               'hasil'=>$row[12],
                    ]);
                }
                if($row[13]!=null){
                    $collection->push((object)['jawaban' => $row[13],
                                               'hasil'=>$row[14],
                    ]);
                }
            }

        foreach($collection as $j){
            $nilai=$this->carinilai($tipe,$j->hasil);
            // dd($nilai);
            DB::table('banksoaljawaban')->insert(
            array(
                'jawaban'     =>   $j->jawaban,
                'hasil'     =>   $j->hasil,
                'nilai'     =>   $nilai,
                'banksoal_id'     =>   $banksoal_id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ));

        }


        }
    }
    // dd($no);
    $no++;
    }
}
}
