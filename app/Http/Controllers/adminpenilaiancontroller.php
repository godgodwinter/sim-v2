<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\kelas;
use App\Models\kompetensidasar;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class adminpenilaiancontroller extends Controller
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
    public function index(Request $request)
    {
        #WAJIB
        $pages='silabus';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $kelas=kelas::get();

        return view('pages.admin.penilaian.index',compact('datas','request','pages','guru','kelas'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='silabus';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')
        ->where('nama','like',"%".$cari."%")
        ->where('kelas_id','like',"%".$request->kelas_id."%")
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $kelas=kelas::get();

        return view('pages.admin.penilaian.index',compact('datas','request','pages','guru','kelas'));
    }

    public function inputnilai(dataajar $dataajar,Request $request)
    {
        #WAJIB
        $pages='silabus';
        $datasiswa=siswa::where('kelas_id',$dataajar->kelas_id)->paginate(Fungsi::paginationjml());
        $datakd=kompetensidasar::with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->get();
        // $datasnilai=new Collection();
        //     foreach($datasiswa as $siswa){
        //         $datasnilai->push((object)[
        //             'id' => $request->id1,
        //             'nomerinduk'=>$request->nomerinduk,
        //             'nama'=>$request->nama,
        //             'kelas_id'=>$request->kelas_id,
        //             'materipokok_id'=>'1',
        //             'nilai'=>'90'
        //         ]);
        //     }
        $datas=$datasiswa;

        // $datas = $datasiswa->map(function ($item, $key) {
        //     return $item * 2;
        // });
        // dd($datas);


        return view('pages.admin.penilaian.inputnilai',compact('datas','request','pages','dataajar','datakd'));
    }
}
