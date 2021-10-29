<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\absensi;
use App\Models\dataajar;
use App\Models\kelas;
use App\Models\siswa;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminabsensicontroller extends Controller
{
    private $kelas_id;
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
        $pages='absensi';
        $datas=kelas::with('guru')
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.absensi.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='kelas';
        $datas=kelas::with('guru')
        ->where('tingkatan','like',"%".$cari."%")
        ->orWhere('jurusan','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.absensi.index',compact('datas','request','pages'));
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
        // dd($kelas);
        $this->kelas_id=$kelas;
        // dd($firstDayofPreviousMonth,$lastDayofPreviousMonth);
        // $datas=siswa::with('kelas')->where('kelas_id',$kelas->id)->paginate(Fungsi::paginationjml());
        $datas=absensi::with('siswa')
        ->whereHas('siswa',function($query){
            global $kelas;
            // global $kelas_id;
            // dd($this->kelas_id);
                $query->where('siswa.kelas_id',$this->kelas_id->id);
        })
        ->orderBy('tgl','desc')
        ->orderBy('created_at','desc')
        ->paginate(Fungsi::paginationjml());

        $siswas=siswa::with('kelas')->where('kelas_id',$this->kelas_id->id)
        ->get();
        // dd($datas,$this->kelas_id->id);
        return view('pages.admin.absensi.detailv2',compact('datas','request','pages','kelas','dates','siswas'));
    }
    public function detail_old(kelas $kelas, Request $request)
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

        return view('pages.admin.absensi.detail',compact('datas','request','pages','kelas','dates'));
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
    public function storev2(kelas $kelas,Request $request){
        // dd($request);
        $cek=absensi::where('siswa_id',$request->siswa_id)
        ->where('tgl',$request->tgl)
        ->count();

        if($cek>0){
            absensi::where('siswa_id',$request->siswa_id)
            ->where('tgl',$request->tgl)
            ->update([
                'nilai'     =>   $request->nilai,
                'ket'     =>   $request->ket,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            DB::table('absensi')->insert(
                array(
                        'ket'     =>   $request->ket,
                        'siswa_id'     =>   $request->siswa_id,
                        'tgl'     =>   $request->tgl,
                        'nilai'     =>   $request->nilai,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));


        }

        return redirect()->back()->with('status','Data berhasil update!')->with('tipe','success')->with('icon','fas fa-feather');


    }
    public function destroy(kelas $kelas,absensi $id){

        absensi::destroy($id->id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }
}
