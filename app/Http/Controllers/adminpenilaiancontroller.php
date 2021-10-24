<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\kompetensidasar;
use App\Models\siswa;
use Illuminate\Http\Request;
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

        return view('pages.admin.penilaian.index',compact('datas','request','pages'));
    }

    public function inputnilai(dataajar $dataajar,Request $request)
    {
        #WAJIB
        $pages='silabus';
        $datas=siswa::where('kelas_id',$dataajar->kelas_id)->paginate(Fungsi::paginationjml());

        $datakd=kompetensidasar::with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->get();
        return view('pages.admin.penilaian.inputnilai',compact('datas','request','pages','dataajar','datakd'));
    }
}
