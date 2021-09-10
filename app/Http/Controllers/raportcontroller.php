<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\siswa;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class raportcontroller extends Controller
{
    
    public function show($nis)
    {
        // dd($nis);
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=siswa::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();
        $datausers = DB::table('users')->where('nomerinduk',$nis)->first();
        $siswa = DB::table('siswa')->where('nis',$nis)->first();
        $mapelumum = DB::table('pelajaran')->where('tipepelajaran','Umum')->get();
        $mapelmulok = DB::table('pelajaran')->where('tipepelajaran','Mulok')->get();

        // dd($siswa);

        return view('admin.raport.index',compact('pages','jmldata','datas','tapel','kelas','siswa','datausers','mapelumum','mapelmulok'));
    }
}
