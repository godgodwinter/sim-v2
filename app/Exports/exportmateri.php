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
use App\Models\materipokok;

class exportmateri implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $kompetensidasar;

    function __construct($kompetensidasar,) {
           $this->kompetensidasar = $kompetensidasar;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Link'
        ];
    }
    public function collection()
    {
        $datas=materipokok::where('kompetensidasar_id',$this->kompetensidasar->id)->get();
        $dataakhir= new Collection();
        $nomer=1;
        foreach($datas as $data){
            $array=[
            'no'=>$nomer,
            'Nama'=>strip_tags($data->nama),
            'link'=> $data->link,
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
