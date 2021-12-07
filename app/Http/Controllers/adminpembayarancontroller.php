<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\tagihandetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminpembayarancontroller extends Controller
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
        $pages='tagihan';
        $kelas=kelas::first();
        $datas=siswa::
        where('kelas_id',$kelas->id)
        ->get();

        return view('pages.admin.pembayaran.index',compact('datas','request','pages','kelas'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='tagihan';
        $datas=tagihandetail::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pembayaran.index',compact('datas','request','pages'));
    }
}
