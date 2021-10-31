<?php

namespace App\Exports;

use App\Helpers\Fungsi;
use App\Http\Resources\dataujianresource;
use App\Http\Resources\siswaresource;
use App\Models\inputnilai;
use App\Models\siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\banksoal;
use App\Models\banksoaljawaban;
use App\Models\kompetensidasar;

class exportkd implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dataajar;

    function __construct($dataajar,) {
           $this->dataajar = $dataajar;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama KD',
            'Tipe ',
            'Kode'
        ];
    }
    public function collection()
    {
        $datas=kompetensidasar::where('dataajar_id',$this->dataajar->id)->get();
        $dataakhir= new Collection();
        $nomer=1;
        foreach($datas as $data){
            $tipe='Pengetahuan';
            if($data->tipe==2){
                $tipe='Ketrampilan';
                $prefix='4.';
            }else{
                $tipe='Pengetahuan';
                $prefix='3.';
            }
            $array=[
            'no'=>$nomer,
            'Nama KD'=>strip_tags($data->nama),
            'tipe'=>$tipe,
            'kode'=>$prefix.$data->kode.' ',
            ];
            // koleksi
            $dataakhir->push((object)$array);
            // $dataakhir=$dataakhir->merge(
            //     'no'=>'123'
            // );
            $nomer++;
        }
        // dd($dataakhir);
        return $dataakhir;
    // $datas = inputnilai::with('siswa')->orderBy('created_at','asc')->get();
    // dd($datas);
        // return dataujianresource::collection($datas);
    }
}
