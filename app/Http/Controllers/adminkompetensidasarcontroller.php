<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\kompetensidasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminkompetensidasarcontroller extends Controller
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
    public function index(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='banksoal';
        $datas=kompetensidasar::with('dataajar')->with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.admin.kompetensidasar.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='banksoal';

        return view('pages.admin.kompetensidasar.create',compact('request','pages','dataajar'));
    }
    public function store(dataajar $dataajar,Request $request){
        // dd($request,$dataajar);
        $cek=kompetensidasar::where('nama',$request->nama)
        ->where('kode',$request->kode)
        ->where('tipe',$request->tipe)
        ->where('dataajar_id',$dataajar->id)
        ->count();

        if($cek>0){

        }else{
            DB::table('kompetensidasar')->insert(
                array(
                       'nama'     =>   $request->nama,
                       'kode'     =>   $request->kode,
                       'tipe'     =>   $request->tipe,
                       'dataajar_id'     =>   $dataajar->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));
        return redirect()->route('dataajar.kompetensidasar',$dataajar->id)->with('status','Data berhasil di tambah!')->with('tipe','success');
        }

    }
}
