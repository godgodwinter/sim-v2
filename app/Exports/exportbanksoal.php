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

class exportbanksoal implements FromCollection, WithHeadings, ShouldAutoSize
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
            'Pertanyaan',
            'Tipe Soal',
            'Tingkat Kesulitan',
            'Gambar',
            'Jawaban A',
            'Hasil A',
            'Jawaban B',
            'Hasil B',
            'Jawaban C',
            'Hasil C',
            'Jawaban D',
            'Hasil D',
            'Jawaban E',
            'Hasil E',
        ];
    }
    public function collection()
    {
        // dd('ada');
        $databanksoal=banksoal::where('dataajar_id',$this->dataajar->id)->get();
        $dataakhir= new Collection();
        $nomer=1;
        foreach($databanksoal as $ds){
            $nilai=null;
            $tipe='Pilihan Ganda';
            if($ds->kategorisoal_nama==2){
                $tipe='Pilihan Ganda Kompleks';
            }elseif($ds->kategorisoal_nama=='3'){
                $tipe='True/False';
            }else{
                $tipe='Pilihan Ganda';
            }
            $array=[
            'no'=>$nomer,
            'pertanyaan'=>strip_tags($ds->pertanyaan),
            'tipe'=>$tipe,
            'tingkatkesulitan'=>$ds->tingkatkesulitan,
            'Gambar'=>''
            ];
            $datajawaban=banksoaljawaban::where('banksoal_id',$ds->id)->get();
            $nomerjawaban=1;
            foreach($datajawaban as $dj){
                $array2=[
                    'Jawaban'.Fungsi::periksaabc($nomerjawaban) => $dj->jawaban,
                    'Hasil'.Fungsi::periksaabc($nomerjawaban) => $dj->hasil
                ];
                $array=array_merge($array,$array2);
                $nomerjawaban++;
            }
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
