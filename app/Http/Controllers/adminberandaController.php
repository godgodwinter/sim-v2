<?php

namespace App\Http\Controllers;

use App\Models\settings;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminberandaController extends Controller
{
    public function index()
    {
        $pages='beranda';
        $siswa = DB::table('siswa')->count();
        $kelas = DB::table('kelas')->count();
        $pemasukan = DB::table('pemasukan')->count();
        //lunas
        $lunas=0;
        $belumlunas=0;


        $counttagihansiswa = DB::table('tagihansiswa')
        ->count();
        // 1.ambil tagihansiswa >nominal , ambil total tagihansiswadetail where id
            $gettagihansiswa = DB::table('tagihansiswa')
            ->get();
            foreach ($gettagihansiswa as $ts){
                $tagihansiswa_id=$ts->id;

            $sumdetailbayar = DB::table('tagihansiswadetail')
            ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            // dd($sumdetailbayar);
                $kurang=$ts->nominaltagihan-$sumdetailbayar;
                if($kurang<=0){
                    $lunas+=1;
                }
            }
            $belumlunas=$counttagihansiswa-$lunas;
            // dd($gettagihansiswa);
        

            $ttlpemasukan = DB::table('pemasukan')
            // ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            $ttlpengeluaran = DB::table('pengeluaran')
            // ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            $saldo=$ttlpemasukan-$ttlpengeluaran;
            $paginationjml=$this->paginationjml();
            $sekolahnama=$this->sekolahnama();
            $sekolahalamat=$this->sekolahalamat();
            $sekolahtelp=$this->sekolahtelp();
            $aplikasijudul=$this->aplikasijudul();
            $aplikasijudulsingkat=$this->aplikasijudulsingkat();
            $nominaltagihandefault=$this->nominaltagihandefault();
            $tapelaktif=$this->tapelaktif();
            $tapel=tapel::all();


        return view('admin.beranda',compact('pages'
        ,'pemasukan'
        ,'kelas'
        ,'tapel'
        ,'siswa',
        'lunas'
        ,'belumlunas'
        ,'ttlpemasukan'
        ,'ttlpengeluaran'
        ,'saldo'
        ,'paginationjml'
        ,'tapelaktif'
        ,'sekolahnama'
        ,'sekolahalamat'
        ,'sekolahtelp'
        ,'nominaltagihandefault'
        ,'aplikasijudul'
        ,'aplikasijudulsingkat'
    ));
        // return view('admin.beranda');


            // $sumdetailbayar = DB::table('tagihansiswadetail')
            // ->where('tagihansiswa_id', '=', $tagihansiswa->id)
            // ->sum('nominal');
    }
    public function settingsstore(Request $request,settings $settings)
    {
        // dd($settings);

        $request->validate([
            'paginationjml'=>'required|numeric|min:3',
            'tapelaktif'=>'required',
            'sekolahnama'=>'required',
            'sekolahalamat'=>'required',
            'sekolahtelp'=>'required',
            'aplikasijudul'=>'required',
            'aplikasijudulsingkat'=>'required',
            'nominaltagihandefault'=>'required',

        ],
        [
            'paginationjml.required'=>'Nama harus diisi',

        ]);

        settings::where('id',$settings->id)
            ->update([
                'paginationjml'=>$request->paginationjml,
                'tapelaktif'=>$request->tapelaktif,
                'sekolahnama'=>$request->sekolahnama,
                'sekolahalamat'=>$request->sekolahalamat,
                'sekolahtelp'=>$request->sekolahtelp,
                'aplikasijudul'=>$request->aplikasijudul,
                'nominaltagihandefault'=>$request->nominaltagihandefault,
                'aplikasijudulsingkat'=>$request->aplikasijudulsingkat,
            ]);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');

    }

    public function notfound()
    {

        return view('404');
    }
}
