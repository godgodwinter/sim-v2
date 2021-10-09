<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class absensicontroller extends Controller
{
    public function index(Request $request)
    {
        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $period = CarbonPeriod::create($firstDayofPreviousMonth, $lastDayofPreviousMonth);


// Iterate over the period
// foreach ($period as $date) {
//     echo $date->format('Y-m-d');
// }

// Convert the period to an array of dates
$dates = $period->toArray();

        dd($firstDayofPreviousMonth,$lastDayofPreviousMonth,$dates,$dates[0]->format('Y-m-d'));


        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakaddataajar';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('dataajar')
        ->orderBy('kelas_nama','asc')
        // ->orderBy('pelajaran_jurusan','desc')
        ->paginate($this->paginationjml());

        $kelas=DB::table('kelas')->get();
        $pelajaran=DB::table('pelajaran')->get();
        $dataguru=DB::table('guru')->get();
        return view('siakad.admin.dataajar.indexpenilaian',compact('datas','pages','request','kelas','pelajaran','dataguru'));
    }
}
