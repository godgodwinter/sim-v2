<?php

namespace App\Exports;

use App\Http\Resources\pegawairesource;
use App\Http\Resources\siswaresource;
use App\Models\siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class Exportpegawai implements FromCollection, WithHeadings, ShouldAutoSize
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
            'nig',
            'kategori_nama',
            'alamat',
            'telp',
            'created_at',
            'updated_at',
            'email',
            'pass',
        ];
    }
    public function collection()
    {
            // return pelanggan::all();
            // $datas=DB::table('siswa')->select('id', 'nama' ,'nis', 'agama', 'tempatlahir','tgllahir','alamat','tapel_nama','kelas_nama' ,'jk','created_at', 'updated_at')->get();
            // dd($datas);
            // return  $datas;

        // $datas=siswa::latest()->get();

    $datas = DB::table('pegawai')
    ->join('users','users.nomerinduk','=','pegawai.nig')
    // ->whereraw('tagihan.paket_harga > tagihan.total_bayar')
    ->get();
    // dd($datas);
        return pegawairesource::collection($datas);
    }
}
