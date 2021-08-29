<?php

namespace App\Http\Controllers;

use App\Models\arsip_siswa;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\tapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pagesController extends Controller
{
    public function formatimport()
    {
        $pages='beranda';
        return view('admin.pages.formatimport',compact('pages'
    ));
    }

    public function guide()
    {
        $pages='beranda';
        return view('admin.pages.guide',compact('pages'
    ));
    }


    public function eoy()
    {
        $pages='eoy';
        return view('admin.pages.eoy',compact('pages'
    ));
    }

    public function eoy_do(Request $request)
    {
        //buat arsipkode
        $arsipkode=date('Ymd');
        // dd($arsipkode);

        // start-DATATAPEL
        //ambildata 
        $datastapel=DB::table('tapel')
        ->get();
        foreach($datastapel as $tapel){

        $datas=DB::table('arsip_tapel')
        ->where('nama',$tapel->nama)
        ->count();
    
            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tapel')->insert(
                        array(
                                'nama' => $tapel->nama,
                                'arsipkode' => $arsipkode,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s"),
                        ));
                }else{

                }
        //hapus semua data ditabel awal
        tapel::destroy($tapel->id);

        }
        // end-DATATAPEL

        // start-DATAKELAS
        //ambildata 
        $dataskelas=DB::table('kelas')
        ->get();
        foreach($dataskelas as $kelas){

        $datas=DB::table('arsip_kelas')
        ->where('nama',$kelas->nama)
        ->count();
    
            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_kelas')->insert(
                        array(
                                'nama' => $kelas->nama,
                                'arsipkode' => $arsipkode,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s"),
                        ));
                }else{

                }
        //hapus semua data ditabel awal
        kelas::destroy($kelas->id);

        }
        // end-DATAKELAS


        // start-DATASISWA
        //ambildata 
        $datassiswa=DB::table('siswa')
        ->get();
        foreach($datassiswa as $siswa){

        $datas=DB::table('arsip_siswa')
        ->where('nis',$siswa->nis)
        ->where('tapel_nama',$siswa->tapel_nama)
        ->where('kelas_nama',$siswa->kelas_nama)
        ->count();
    
            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_siswa')->insert(
                        array(
                            'nis'     =>   $siswa->nis,
                            'nama'     =>   $siswa->nama,
                            'tempatlahir'     =>   $siswa->tempatlahir,
                            'tgllahir'     =>   $siswa->tgllahir,
                            'agama'     =>   $siswa->agama,
                            'alamat'     =>   $siswa->alamat,
                            'tapel_nama'     =>   $siswa->tapel_nama,
                            'kelas_nama'     =>   $siswa->kelas_nama,
                            'jk'     =>   $siswa->jk,
                            'moodleuser'     =>   $siswa->moodleuser,
                            'moodlepass'     =>   $siswa->moodlepass,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                        ));
                }else{
                    arsip_siswa::where('nis',$siswa->nis)
                    ->where('tapel_nama',$siswa->tapel_nama)
                    ->where('kelas_nama',$siswa->kelas_nama)
                        ->update([
                           'nama'     =>   $siswa->nama,
                           'tempatlahir'     =>   $siswa->tempatlahir,
                           'tgllahir'     =>   $siswa->tgllahir,
                           'agama'     =>   $siswa->agama,
                           'alamat'     =>   $siswa->alamat,
                           'jk'     =>   $siswa->jk,
                           'moodleuser'     =>   $siswa->moodleuser,
                           'moodlepass'     =>   $siswa->moodlepass,
                           'updated_at'=>date("Y-m-d H:i:s")
                        ]);

                }
        //hapus semua data ditabel awal
        siswa::destroy($siswa->id);

        }
        // end-DATASISWA

        dd($arsipkode);
    }


    public function soy()
    {
        $pages='soy';
        return view('admin.pages.guide',compact('pages'
    ));
    }

    public function arsip()
    {
        $pages='arsip';
        return view('admin.pages.guide',compact('pages'
    ));
    }
}
