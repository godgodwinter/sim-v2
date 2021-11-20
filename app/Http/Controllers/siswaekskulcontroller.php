<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\inputnilai;
use App\Models\kelas;
use App\Models\kompetensidasar;
use App\Models\mapel;
use App\Models\materipokok;
use App\Models\siswa;
use App\Models\ekskul;
use App\Models\ekskuldetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $pages='materibelajar';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('kelas_id',$datasiswa->kelas_id)
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $caridataajar=dataajar::where('kelas_id',$datasiswa->kelas_id)->get();

        return view('pages.siswa.dataajar.index',compact('datas','request','pages','guru','caridataajar'));
    }
    public function cari(Request $request)
    {
       // dd($request);
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        $cari=$request->cari;
        #WAJIB
        $pages='materibelajar';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('kelas_id',$datasiswa->kelas_id)
        ->where('nama','like',"%".$request->mapel."%")

        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        // $kelas=kelas::get();
        $caridataajar=dataajar::where('kelas_id',$datasiswa->kelas_id)->get();

        return view('pages.siswa.dataajar.index',compact('datas','request','pages','guru','caridataajar'));
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
    public function lihatnilai(inputnilai $data, dataajar $d, Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        #WAJIB
        $pages='penilaian';
        // $datas=inputnilai::with('siswa')->with('materipokok')
        // ->where('siswa_id',$datasiswa->id)
        // ->orderBy('id','asc')
        // ->paginate(Fungsi::paginationjml());

        //  $datas=dataajar::with('mapel')->with('guru')

        //  ->where('kelas_id',$datasiswa->kelas_id)
        //  ->paginate(Fungsi::paginationjml());

        //   $dat=DB::select("select ma.nama as na, gur.nama as gu, AVG(inilai.nilai) as nil
        //                       FROM dataajar da INNER JOIN mapel ma on da.mapel_id=ma.id
        //                       INNER JOIN guru gur ON da.guru_id=gur.id
        //                       INNER JOIN kompetensidasar ko on da.id=ko.dataajar_id
        //                       INNER JOIN materipokok mo on ko.id=mo.id
        //                       INNER JOIN inputnilai inilai on mo.id=inilai.id
        //                       WHERE  inilai.siswa_id=".$datasiswa->id)
        //                       ;
        $datas=dataajar::with('guru')
        ->where('kelas_id',$datasiswa->kelas_id)
        ->orderBy('nama','asc')
        ->paginate(Fungsi::paginationjml());
         //dd($dat);
        return view('pages.siswa.dataajar.lihatnilai',compact('datas','request','pages','data','datasiswa'));
    }
}
