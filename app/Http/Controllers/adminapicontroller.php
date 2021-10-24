<?php

namespace App\Http\Controllers;

use App\Models\dataajar;
use App\Models\inputnilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminapicontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
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
}