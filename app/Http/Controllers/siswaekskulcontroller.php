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

class siswaekskulcontroller extends Controller
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
        $datas=ekskuldetail::with('ekskul')->with('siswa')
        //->avg('nilai')
        ->where('siswa_id',$datasiswa->id)
        ->paginate(Fungsi::paginationjml());
        foreach($datas as $dat){
            $idg=$dat->ekskul->guru_id;
            if($dat->nilai != null){
                $nilai=$dat->nilai / $dat->count();
            }else{
                $nilai='0';
            }
        }
        $guru=guru::where('id',$idg)->get();
        foreach($guru as $gur){
            $namaguru=$gur->nama;
        }
        //$caridataajar=dataajar::where('kelas_id',$datasiswa->kelas_id)->get();

        return view('pages.siswa.dataajar.ekskul.index',compact('datas','request','pages','namaguru','nilai'));
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

}
