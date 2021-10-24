<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\kelas;
use App\Models\siswa;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminabsensicontroller extends Controller
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
        $pages='absensi';
        $datas=kelas::with('guru')
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

        // dd($firstDayofPreviousMonth,$lastDayofPreviousMonth);
        $datas=siswa::paginate(Fungsi::paginationjml());

        return view('pages.admin.absensi.detail',compact('datas','request','pages','kelas','dates'));
    }
}
