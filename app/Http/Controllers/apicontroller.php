<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class apicontroller extends Controller
{

    public function tingkatkesulitan (Request $request)
    {

        $output = '';
        $datas = '';
        $first = '';
        $warna = 'text-dark';


        $pertanyaan=$request->pertanyaan;
        $month = date("m",strtotime($request->bln));
        $year = date("Y",strtotime($request->bln));
        $output = $request->pertanyaan;


        $output='mudah';
        // 1. pecah spasi explod input pertanyaan
        $strex=explode(" ",$pertanyaan);

        foreach($strex as $str){
            // cek sedang
            $cektingkatkesulitan=DB::table('kko')
            ->where('nama',$str)
            ->where('tipe','sedang')
            ->count();
            if($cektingkatkesulitan>0){
                $ambildata=DB::table('kko')
                ->where('nama',$str)
                // ->where('nama','like',"%".$str."%")
                ->where('tipe','sedang')
                ->first();
                $output=$ambildata->tipe;
                $warna = 'text-warning';

            }

            //cek sulit
            $cektingkatkesulitan2=DB::table('kko')
            ->where('nama',$str)
            // ->where('nama','like',"%".$str."%")
            ->where('tipe','sulit')
            ->count();

            if($cektingkatkesulitan2>0){
                $ambildata2=DB::table('kko')
                ->where('nama',$str)
                ->where('tipe','sulit')
                ->first();
                $output=$ambildata2->tipe;
                $warna = 'text-danger';

            }
            // $output='adsad';
        }
        // 2. cari jika ditemukan sedang dan sulit maka ganti tingkat kesulitan soal
        // 3. tampilkan berdasarkan json
        // dd($strex,$output);

    // $jml=DB::table('peminjamandetail')
    // ->where('buku_nama','like',"%".$cari."%")->where('statuspengembalian',$request->status)->whereMonth('tgl_pinjam',$month)->whereYear('tgl_pinjam',$year)->skip(0)->take(10)
    // ->orWhere('buku_pengarang','like',"%".$cari."%")->where('statuspengembalian',$request->status)->whereMonth('tgl_pinjam',$month)->whereYear('tgl_pinjam',$year)->skip(0)->take(10)
    // ->orWhere('buku_penerbit','like',"%".$cari."%")->where('statuspengembalian',$request->status)->whereMonth('tgl_pinjam',$month)->whereYear('tgl_pinjam',$year)->skip(0)->take(10)
    // ->count();


    //         $output = '
    //         <tr>
    //          <td align="center" colspan="5">No Data Found</td>
    //         </tr>
    //         ';

        // echo json_encode($datas);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
            // 'status' => $data->status,
            'warna' => $warna,
            'datas' => $datas,
            'first' => $first
        ], 200);

        // dd($datas);


    }
    public function generatekompetensidasar(Request $request){
        $output='';
        $datas='';
        $warna='';
        $first='';

        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;
        $pelajaran_nama=$request->pelajaran_nama;
        $tipe=$request->tipe;

        $kode=Fungsi::kompetensidasargeneratekode($tapel_nama,$kelas_nama,$pelajaran_nama,$tipe);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $kode,
            // 'status' => $data->status,
            'warna' => $warna,
            'datas' => $datas,
            'first' => $first
        ], 200);

    }
}
