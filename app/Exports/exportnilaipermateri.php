<?php

namespace App\Exports;

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

class exportnilaipermateri implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dataajar;
    protected $materipokok;

    function __construct($dataajar,$materipokok) {
           $this->dataajar = $dataajar;
           $this->materipokok = $materipokok;
    }

    public function headings(): array
    {
        return [
            'Nomerinduk',
            'Nama Siswa',
            'Nilai',
        ];
    }
    public function collection()
    {
        $datasiswa=siswa::where('kelas_id',$this->dataajar->kelas_id)->get();
        $dataakhir= new Collection();
        foreach($datasiswa as $ds){
            $nilai=null;
            $ambilnilai=inputnilai::where('siswa_id',$ds->id)->where('materipokok_id',$this->materipokok->id)->first();
            if($ambilnilai!=null){
                $nilai=$ambilnilai->nilai;
            }
            $dataakhir->push((object)[
                'nomerinduk'=>$ds->nomerinduk,
                'nama'=>$ds->nama,
                'nilai'=>$nilai,
            ]);
        }
        // dd($dataakhir,$datasiswa);
        return $dataakhir;

    // $datas = inputnilai::with('siswa')->orderBy('created_at','asc')->get();
    // dd($datas);
        // return dataujianresource::collection($datas);
    }
}
