<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\kelas;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class siswadataajarcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='siswa'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();

        #WAJIB
        $pages='penilaian';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('kelas_id',$datasiswa->kelas_id)
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $kelas=kelas::get();

        return view('pages.siswa.dataajar.index',compact('datas','request','pages','guru','kelas'));
    }
    public function cari(Request $request)
    {

        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        $cari=$request->cari;
        #WAJIB
        $pages='penilaian';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('kelas_id',$datasiswa->kelas_id)
        ->where('nama','like',"%".$cari."%")
        ->where('kelas_id','like',"%".$request->kelas_id."%")
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $kelas=kelas::get();

        return view('pages.siswa.dataajar.index',compact('datas','request','pages','guru','kelas'));
    }
    public function materi(dataajar $dataajar, Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        #WAJIB
        $pages='silabus';
        $datas=kompetensidasar::with('dataajar')->with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.siswa.dataajar.materi',compact('datas','request','pages','dataajar','datasiswa'));
    }

    public function materidetail(dataajar $dataajar,kompetensidasar $kd, Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        #WAJIB
        $pages='banksoal';
        $datas=materipokok::with('kompetensidasar')
        ->where('kompetensidasar_id',$kd->id)
        ->orderBy('id','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.siswa.dataajar.materidetail',compact('datas','request','pages','kd','dataajar','datasiswa'));
    }
}
