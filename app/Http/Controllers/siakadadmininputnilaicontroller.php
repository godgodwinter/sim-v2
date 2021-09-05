<?php

namespace App\Http\Controllers;

use App\Models\dataajar;
use App\Models\kelas;
use App\Models\nilaipelajaran;
use App\Models\pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadadmininputnilaicontroller extends Controller
{
    public function mapel(dataajar $dataajar){
        // dd($kelas);
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='dataajar';
        $jmldata='0';
        $datas='0';

        $dataajar=$dataajar;

        // $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();
        $datajenisnilai=DB::table('jenisnilai')->orderBy('kode','asc')->get();
        $datasiswa=DB::table('siswa')->where('kelas_nama',$dataajar->kelas_nama)->orderBy('nama','asc')->get();


        $jmldata = DB::table('pelajaran')->count();
        
        return view('siakad.admin.inputnilai.index',compact('pages','jmldata','dataajar','datasiswa','datajenisnilai'));
    }
    public function mapel_store(dataajar $dataajar,Request $request){
        // dd($dataajar);
        $request->validate([
            'nilai'=>'required|numeric|min:1|max:100',

        ],
        [
            'nilai.required'=>'nilai Harus diisi',

        ]);


    // $dataguru=DB::table('guru')
    // ->where('nomerinduk', '=', $request->guru_nomerinduk)
    // ->first();
    // dd($dataajar);
    // $guru_nama=$dataguru->nama;

    $ceknilaipelajaran=DB::table('nilaipelajaran')
    ->where('siswa_nis', '=', $request->siswa_nis)
    ->where('kelas_nama', '=', $dataajar->kelas_nama)
    ->where('jenisnilai_nama', '=', $request->jenisnilai_nama)
    ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
    // ->where('guru_nama', '=', $request->guru_nama)
    ->count();
    if($ceknilaipelajaran>0){

        nilaipelajaran::where('siswa_nis',$request->siswa_nis)
        ->where('kelas_nama', '=', $dataajar->kelas_nama)
        ->where('jenisnilai_nama', '=', $request->jenisnilai_nama)
        ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
            ->update([
                'nilai'=>$request->nilai,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }else{
        
       DB::table('nilaipelajaran')->insert(
        array(
               'siswa_nis'     =>   $request->siswa_nis,
               'siswa_nama'     =>   $request->siswa_nama,
               'kelas_nama'     =>   $dataajar->kelas_nama,
               'jenisnilai_nama'     =>   $request->jenisnilai_nama,
               'nilai'     =>   $request->nilai,
               'pelajaran_nama'     =>   $dataajar->pelajaran_nama,
               'guru_nama'     =>   $dataajar->guru_nama,
               'guru_nomerinduk'     =>   $dataajar->guru_nomerinduk,
               'tapel_nama'     =>   $this->tapelaktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
    }

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }
}
