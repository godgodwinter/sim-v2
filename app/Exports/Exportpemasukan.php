<?php

namespace App\Exports;

use App\Http\Resources\pemasukanresource;
use App\Http\Resources\siswaresource;
use App\Http\Resources\tapelresource;
use App\Models\siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class Exportpemasukan implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         // Style the first row as bold text.
    //         1    => ['font' => ['bold' => true]],


    //     ];
    // }

    public function headings(): array
    {
        return [
            'id',
            'nama',
            'nominal',
            'kategori_nama',
            'catatan',
            'tglbayar',
            'created_at',
            'updated_at',
        ];
    }
    public function collection()
    {
            // return pelanggan::all();
            // $datas=DB::table('siswa')->select('id', 'nama' ,'nis', 'agama', 'tempatlahir','tgllahir','alamat','tapel_nama','kelas_nama' ,'jk','created_at', 'updated_at')->get();
            // dd($datas);
            // return  $datas;

        // $datas=siswa::latest()->get();

    $datas = DB::table('pemasukan')
    // ->join('users','users.nomerinduk','=','siswa.nis')
    // ->whereraw('tagihan.paket_harga > tagihan.total_bayar')
    ->get();
    // dd($datas);
        return pemasukanresource::collection($datas);
    }
}
