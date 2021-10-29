<?php

namespace App\Exports;

use App\Helpers\Fungsi;
use App\Http\Resources\dataujianresource;
use App\Http\Resources\siswaresource;
use App\Models\inputnilai;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use App\Models\siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class exportnilaiperkd implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dataajar;
    protected $kompetensidasar;

    function __construct($dataajar,$kompetensidasar) {
           $this->dataajar = $dataajar;
           $this->kompetensidasar = $kompetensidasar;
    }

    public function headings(): array
    {
        $array=[
            'nomerinduk',
            'nama',
        ];
        $datamateri=materipokok::where('kompetensidasar_id',$this->kompetensidasar->id)->get();
        foreach($datamateri as $dm){
            // dd(Fungsi::ambilkdmateripokok($dm->id));
            // $id=$dm->id;
            $id=Fungsi::ambilkdmateripokok($dm->id,$this->dataajar->id);
            $arraydua=[$id];
            $array=array_merge($array,$arraydua);
        }
        return $array;
    }
    public function collection()
    {
        $datasiswa=siswa::where('kelas_id',$this->dataajar->kelas_id)->get();
        $dataakhir= new Collection();
        foreach($datasiswa as $ds){
        //     $nilai=null;

        $array=[
            'nomerinduk'=>$ds->nomerinduk,
            'nama'=>$ds->nama
        ];


            $datamateri=materipokok::where('kompetensidasar_id',$this->kompetensidasar->id)->get();
            foreach($datamateri as $dm){
                $id=$dm->id;
                $nilai=null;
            $ambilnilai=inputnilai::where('siswa_id',$ds->id)->where('materipokok_id',$id)->first();
            if($ambilnilai!=null){
                $nilai=$ambilnilai->nilai;
            }
            $arraydua=[$id => $nilai];
            $array=array_merge($array,$arraydua);


                    // $dataakhir->push((object)[
                    //     'nomerinduk'=>$ds->nomerinduk,
                    //     'nama'=>$ds->nama,
                    //     'nilai'=>$nilai,
                    // ]);

                // dd($dataakhir);
            }
            $dataakhir->push((object)$array);
            // dd($dataakhir);
        //     $ambilnilai=inputnilai::where('siswa_id',$ds->id)->where('materipokok_id',$this->materipokok->id)->first();
        //     if($ambilnilai!=null){
        //         $nilai=$ambilnilai->nilai;
        //     }
        //     $dataakhir->push((object)[
        //         'nomerinduk'=>$ds->nomerinduk,
        //         'nama'=>$ds->nama,
        //         'nilai'=>$nilai,
        //     ]);
        }
        // dd($dataakhir,$datasiswa);
        return $dataakhir;

    // $datas = inputnilai::with('siswa')->orderBy('created_at','asc')->get();
    // dd($datas);
        // return dataujianresource::collection($datas);
    }
}
