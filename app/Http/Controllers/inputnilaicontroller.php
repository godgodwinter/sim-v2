<?php

namespace App\Http\Controllers;

use App\Models\nilaipelajaran;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class inputnilaicontroller extends Controller
{
    public function index(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama,$materipokok_nama,$kompetensidasar_kode,$kompetensidasar_tipe){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);
        $mp_nama=base64_decode($materipokok_nama);
        $kd_kode=base64_decode($kompetensidasar_kode);
        $kd_tipe=base64_decode($kompetensidasar_tipe);

        $kodegenerate=Uuid::uuid4()->getHex();

        // dd($p_nama,$k_nama,$t_nama,$mp_nama,$kd_kode,$kd_tipe,$kodegenerate);

        #WAJIB
        $pages='inputnilai';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('banksoal')
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->where('materipokok_nama',$mp_nama)
                ->where('kompetensidasar_kode',$kd_kode)
                ->where('kompetensidasar_tipe',$kd_tipe)
                // ->where('kode',1)
                // ->orWhere('pelajaran_nama',$p_nama)
                // ->where('kelas_nama',$k_nama)
                // ->where('tapel_nama',$t_nama)
                // ->where('kode',2)
                ->orderBy('created_at','desc')
        ->get();

        $datasiswa=DB::table('siswa')->where('kelas_nama',$k_nama)->get();
        $datakd=DB::table('kompetensidasar')
            ->where('kelas_nama',$k_nama)
            ->where('tapel_nama',$t_nama)
            ->where('pelajaran_nama',$p_nama)
            ->orderBy('kode','asc')
            ->orderBy('tipe','desc')
            ->get();

            // $datakd=$datakdtanpauniq->unique('kode');

        // $datas=$datastanpauniq->unique('kode');



        // $generate_kode=Fungsi::kompetensidasargeneratekode($t_nama,$k_nama,$p_nama);

        // 1. ambil datas dari tabel kompetensi dasar where tapel kelas dan pelajarannama
        // 1. ambil last id (Fungsi generatekompetesiid)
        // dd($request);

        return view('admin.inputnilaibaru.index',compact('pages','datas','request'
        ,'kodegenerate'
        ,'datasiswa'
        ,'datakd'
        ,'k_nama'
        ,'t_nama'
        ,'p_nama'
        ,'pelajaran_nama','kelas_nama','tapel_nama'
        ,'materipokok_nama'
        ,'kompetensidasar_kode'
        ,'kompetensidasar_tipe'
    ));

    }

    public function store(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama,$materipokok_nama,$kompetensidasar_kode,$kompetensidasar_tipe){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);
        $mp_nama=base64_decode($materipokok_nama);
        $kd_kode=base64_decode($kompetensidasar_kode);
        $kd_tipe=base64_decode($kompetensidasar_tipe);
        // 1. periksa apakah data sudah ada
        $cek=DB::table('nilaipelajaran')
                ->where('siswa_nis',$request->siswa_nis)
                ->where('materipokok_nama',$request->materipokok_nama)
                ->where('kompetensidasar_kode',$request->kompetensidasar_kode)
                ->where('kompetensidasar_tipe',$request->kompetensidasar_tipe)
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->count();
                // dd($request,$cek);
                // jika belum maka insert
                if($cek<1){
                    DB::table('nilaipelajaran')->insert(
                     array(
                            'siswa_nama'     =>   $request->siswa_nama,
                            'siswa_nis'     =>   $request->siswa_nis,
                            'nilai'     =>   $request->nilai,
                            'materipokok_nama'     =>   $request->materipokok_nama,
                            'kompetensidasar_kode'     =>   $request->kompetensidasar_kode,
                            'kompetensidasar_tipe'     =>   $request->kompetensidasar_tipe,
                            'pelajaran_nama'     =>   $p_nama,
                            'kelas_nama'     =>   $k_nama,
                            'tapel_nama'     =>   $t_nama,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                     ));

                }else{
                    // jika sudah maka update

                    nilaipelajaran::where('siswa_nis',$request->siswa_nis)
                        ->where('materipokok_nama',$request->materipokok_nama)
                        ->where('kompetensidasar_kode',$request->kompetensidasar_kode)
                        ->where('kompetensidasar_tipe',$request->kompetensidasar_tipe)
                        ->where('pelajaran_nama',$p_nama)
                        ->where('kelas_nama',$k_nama)
                        ->where('tapel_nama',$t_nama)
                        ->update([
                            'nilai'=>$request->nilai,
                        ]);

                }
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }
}
