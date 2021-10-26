<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\guru;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class gurukelascontroller extends Controller
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
        // dd($guru_id);
        #WAJIB
        $pages='kelas';
        $datas=kelas::with('guru')->where('guru_id',$guru_id)
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        $guru=guru::get();

        return view('pages.guru.kelas.index',compact('datas','request','pages','guru'));
    }
    public function cari(Request $request)
    {

        $guru_id=guru::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
        $cari=$request->cari;
        #WAJIB
        $pages='kelas';
        $datas=kelas::with('guru')->where('guru_id',$guru_id)
        ->where('tingkatan','like',"%".$cari."%")
        ->orWhere('jurusan','like',"%".$cari."%")->where('guru_id',$guru_id)
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();

        return view('pages.guru.kelas.index',compact('datas','request','pages','guru'));
    }
}
