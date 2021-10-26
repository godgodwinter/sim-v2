<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\absensi;
use App\Models\guru;
use App\Models\kelas;
use App\Models\siswa;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class guruabsensicontroller extends Controller
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
        #WAJIB
        $pages='absensi';
        $datas=kelas::with('guru')->where('guru_id',$guru_id)
        ->paginate(Fungsi::paginationjml());

        return view('pages.guru.absensi.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $guru_id=guru::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
        $cari=$request->cari;
        #WAJIB
        $pages='kelas';
        $datas=kelas::with('guru')->where('guru_id',$guru_id)
        ->where('tingkatan','like',"%".$cari."%")
        ->orWhere('jurusan','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.guru.absensi.index',compact('datas','request','pages'));
    }
    public function detail(kelas $kelas, Request $request)
    {
        #WAJIB
        $pages='absensi';

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->endOfMonth()->toDateString();
        $period = CarbonPeriod::create($firstDayofPreviousMonth, $lastDayofPreviousMonth);
        // Convert the period to an array of dates
        $dates = $period->toArray();

        // dd($firstDayofPreviousMonth,$lastDayofPreviousMonth);
        $datas=siswa::where('kelas_id',$kelas->id)->paginate(Fungsi::paginationjml());

        return view('pages.guru.absensi.detail',compact('datas','request','pages','kelas','dates'));
    }
    public function store(kelas $kelas,Request $request){
        $cek=absensi::where('siswa_id',$request->siswa_id)
        ->where('tgl',$request->tgl)
        ->count();

        if($cek>0){
            absensi::where('siswa_id',$request->siswa_id)
            ->where('tgl',$request->tgl)
            ->update([
                'ket'     =>   $request->ket,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            DB::table('absensi')->insert(
                array(
                        'ket'     =>   $request->ket,
                        'siswa_id'     =>   $request->siswa_id,
                        'tgl'     =>   $request->tgl,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));


        }

        return redirect()->back()->with('status','Data berhasil update!')->with('tipe','success')->with('icon','fas fa-feather');


    }
}
