<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\inputnilai;
use App\Models\kelas;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminapicontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function inputnilaistore(dataajar $dataajar, Request $request)
    {
        // dd($request);
        $cek=inputnilai::where('siswa_id',$request->siswa_id)
        ->where('materipokok_id',$request->materipokok_id)
        ->count();
        if($cek>0){
            inputnilai::where('siswa_id',$request->siswa_id)
            ->where('materipokok_id',$request->materipokok_id)
            ->update([
                'nilai'     =>   $request->nilai,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }else{

            DB::table('inputnilai')->insert(
                array(
                        'nilai'     =>   $request->nilai,
                        'siswa_id'     =>   $request->siswa_id,
                        'materipokok_id'     =>   $request->materipokok_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));

        }

        $output='Data berhasil di update';
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
        ], 200);
    }

    public function siswaperkelas(kelas $kelas, Request $request)
    {
        $datas=siswa::with('kelas')->where('kelas_id',$kelas->id)
        ->get();
        $output='Data berhasil di ambil';
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
            'datas' => $datas,
        ], 200);
    }
    public function periksatingkatkesulitan(Request $request)
    {
        $warna='form-control btn-info';
        $output=Fungsi::periksatingkatkesulitan($request->pertanyaan);
        // dd($request->pertanyaan,$output);
        // $output='Data berhasil di ambil';
        $datas=$request->pertanyaan;
        if($output=='sulit'){
            $warna='form-control btn-danger';
        }else if($output=='sedang'){
            $warna='form-control btn-warning';
        }else{
            $warna='form-control btn-info';

        }
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
            'warna' => $warna,
            'datas' => $datas,
        ], 200);
    }
    public function kompetensidasargeneratekode(dataajar $dataajar, Request $request)
    {
        $output=1;
        $output=Fungsi::kompetensidasargeneratekode($dataajar,$request->tipe);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
        ], 200);
    }
}
