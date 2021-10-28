<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminsilabuscontroller extends Controller
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

        return view('pages.admin.silabus.index',compact('datas','request','pages','guru','kelas'));
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

        return view('pages.admin.silabus.index',compact('datas','request','pages','guru','kelas'));
    }
    public function pengajarstore(dataajar $id,Request $request)
    {
            $request->validate([
                'guru_id'=>'required',

            ],
            [
                'guru_id.nama'=>'tingkatan harus diisi',
            ]);


        dataajar::where('id',$id->id)
        ->update([
            'guru_id'     =>   $request->guru_id,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);



    return redirect()->back()->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
