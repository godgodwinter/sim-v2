<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kelas;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminpelanggarancontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        #WAJIB
        $pages='pelanggaran';
        $datas=kelas::with('guru')
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pelanggaran.index',compact('datas','request','pages'));
    }
    public function detail(kelas $kelas, Request $request)
    {
        #WAJIB
        $pages='pelanggaran';

        // dd($firstDayofPreviousMonth,$lastDayofPreviousMonth);
        $datas=siswa::where('kelas_id',$kelas->id)->with('pelanggaran')->paginate(Fungsi::paginationjml());

        return view('pages.admin.pelanggaran.detail',compact('datas','request','pages','kelas'));
    }

    public function store(kelas $kelas, Request $request)
    {

        DB::table('pelanggaran')->insert(
            array(
                    'nama'     =>   $request->nama,
                    'siswa_id'     =>   $request->siswa_id,
                    'skor'     =>   $request->skor,
                    'tgl'     =>   $request->tgl,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));

    return redirect()->back()->with('status','Data berhasil ditambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
