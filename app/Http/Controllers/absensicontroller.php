<?php

namespace App\Http\Controllers;

use App\Models\absensi;
use App\Models\kelas;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class absensicontroller extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='kelas';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());

        $gurus=DB::table('guru')
        ->get();

        $jmldata = DB::table('kelas')->count();

        return view('admin.absensi.index',compact('pages','jmldata','datas','request','gurus'));
        // return view('admin.beranda');
    }
    public function detail(Request $request,kelas $id)
    {
        // dd($id);
        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->endOfMonth()->toDateString();
        // $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        // $lastDayofPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $period = CarbonPeriod::create($firstDayofPreviousMonth, $lastDayofPreviousMonth);


// Iterate over the period
// foreach ($period as $date) {
//     echo $date->format('Y-m-d');
// }

// Convert the period to an array of dates
$dates = $period->toArray();
//
        // dd($firstDayofPreviousMonth,$lastDayofPreviousMonth,$dates,$dates[0]->format('Y-m-d'));


        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakaddataajar';
        $jmldata='0';
        $datas='0';

        $kelas=$id;
        $datas=DB::table('siswa')
        ->where('kelas_nama',$id->nama)
        ->orderBy('nis','asc')
        // ->orderBy('pelajaran_jurusan','desc')
        ->paginate($this->paginationjml());

        return view('admin.absensi.detail',compact('datas','pages','request','kelas','dates'));
    }
    public function store(Request $request,kelas $id)
    {
        // dd($request,$id);
        $ambildata=DB::table('absensi')
            ->where('siswa_nama',$request->siswa_nama)
            ->where('siswa_nis',$request->siswa_nis)
            ->where('kelas_nama',$id->nama)
            ->where('tanggal_masuk',$request->tanggal_masuk)
            ->count();
        if($ambildata>0){

            absensi::where('siswa_nama',$request->siswa_nama)
            ->where('siswa_nis',$request->siswa_nis)
            ->where('kelas_nama',$id->nama)
            ->where('tanggal_masuk',$request->tanggal_masuk)
                ->update([
                    'ket'=>$request->ket,
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);

        }else{
            DB::table('absensi')->insert(
                array(
                    'siswa_nama'     =>   $request->siswa_nama,
                    'siswa_nis'     =>   $request->siswa_nis,
                    'kelas_nama'     =>   $id->nama,
                    // 'tapel_nama'     =>   $kategorisoal_nama,
                    'tanggal_masuk'     =>   $request->tanggal_masuk,
                    'ket'     =>   $request->ket,
                    // 'guru_nomerinduk'     =>   $kodegenerate,
                    // 'guru_nama'     =>   $kodegenerate,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ));

        }

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
