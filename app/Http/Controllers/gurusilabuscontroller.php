<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class gurusilabuscontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        $guru_id=guru::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
        #WAJIB
        $pages='silabus';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('guru_id',$guru_id)
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $kelas=kelas::get();

        return view('pages.guru.silabus.index',compact('datas','request','pages','guru','kelas'));
    }
    public function cari(Request $request)
    {

        $guru_id=guru::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
        $cari=$request->cari;
        #WAJIB
        $pages='silabus';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('guru_id',$guru_id)
        ->where('nama','like',"%".$cari."%")
        ->where('kelas_id','like',"%".$request->kelas_id."%")
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $kelas=kelas::get();

        return view('pages.guru.silabus.index',compact('datas','request','pages','guru','kelas'));
    }
}
