<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\tapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class settingsController extends Controller
{
    public function index()
    {
        $pages='settings';
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
                $siswa_nis=$ts->siswa_nis;
                $tapel_nama=$ts->tapel_nama;
                $kelas_nama=$ts->kelas_nama;

            $sumdetailbayar = DB::table('tagihansiswadetail')
            ->where('siswa_nis', '=', $ts->siswa_nis)
            ->where('tapel_nama', '=', $ts->tapel_nama)
            ->where('kelas_nama', '=', $ts->kelas_nama)
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
            $passdefaultsiswa=$this->passdefaultsiswa();
            $passdefaultortu=$this->passdefaultortu();
            $passdefaultpegawai=$this->passdefaultpegawai();
            $sekolahlogo=$this->sekolahlogo();
            $sekolahttd=$this->sekolahttd();
            $sekolahttd2=$this->sekolahttd2();
            $minimalpembayaranujian=$this->minimalpembayaranujian();
            $tapelaktif=$this->tapelaktif();
            $tapel=tapel::all();

            $semester = DB::table('kategori')
            ->where('prefix', '=', 'semester')
            ->get();

        return view('admin.settings.index',compact('pages'
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
        ,'passdefaultsiswa'
        ,'passdefaultortu'
        ,'passdefaultpegawai'
        ,'sekolahlogo'
        ,'sekolahttd'
        ,'sekolahttd2'
        ,'minimalpembayaranujian'
        ,'semester'
    ));
    }

    public function resetsiswa(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('siswa')
        ->paginate($this->paginationjml());

        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        return view('admin.settings.resetsiswa',compact('pages','jmldata','datas','tapel','kelas','request'));
        // return view('admin.beranda');
    }


    public function resetsemua(Request $request)
    {
        $datas=DB::table('siswa')->get();
            foreach($datas as $siswa)
            {
                User::where('nomerinduk',$siswa->nis)
                ->update([
                    'password' => Hash::make(Fungsi::passdefaultsiswa()),
                   'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }
            return redirect()->back()->with('status','Data berhasil direset!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function resetsiswacari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;

        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('siswa')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->orWhere('nis','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();


        return view('admin.settings.resetsiswa',compact('pages','jmldata','datas','tapel','kelas','request'));
    }
}
