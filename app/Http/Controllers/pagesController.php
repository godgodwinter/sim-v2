<?php

namespace App\Http\Controllers;

use App\Models\arsip_siswa;
use App\Models\arsip_tagihanatur;
use App\Models\arsip_tagihansiswa;
use App\Models\arsip_tagihansiswadetail;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\tagihanatur;
use App\Models\tagihansiswa;
use App\Models\tagihansiswadetail;
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
        $arsipkode=date('Y-m-d');
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
                                'created_at'=>$tapel->created_at,
                                'updated_at'=>$tapel->updated_at
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
                                'created_at'=>$kelas->created_at,
                                'updated_at'=>$kelas->updated_at
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
                            'arsipkode' => $arsipkode,
                            'created_at'=>$siswa->created_at,
                            'updated_at'=>$siswa->updated_at
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
                           'updated_at'=>$siswa->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        siswa::destroy($siswa->id);

        }
        // end-DATASISWA


        // start-DATATAGIHANATUR
        //ambildata 
        $datastagihanatur=DB::table('tagihanatur')
        ->get();
        foreach($datastagihanatur as $tagihanatur){

        $datas=DB::table('arsip_tagihanatur')
        ->where('tapel_nama',$tagihanatur->tapel_nama)
        ->where('kelas_nama',$tagihanatur->kelas_nama)
        ->count();
    
            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tagihanatur')->insert(
                        array(
                            'tapel_nama'     =>   $tagihanatur->tapel_nama,
                            'kelas_nama'     =>   $tagihanatur->kelas_nama,
                            'nominaltagihan'     =>   $tagihanatur->nominaltagihan,
                            'gambar'     =>   $tagihanatur->gambar,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$tagihanatur->created_at,
                            'updated_at'=>$tagihanatur->updated_at
                        ));
                }else{
                    arsip_tagihanatur::where('tapel_nama',$tagihanatur->tapel_nama)
                    ->where('kelas_nama',$tagihanatur->kelas_nama)
                        ->update([
                           'nominaltagihan'     =>   $tagihanatur->nominaltagihan,
                           'gambar'     =>   $tagihanatur->gambar,
                           'updated_at'=>$tagihanatur->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        tagihanatur::destroy($tagihanatur->id);

        }
        // end-DATATAGIHANATUR


        // start-DATATAGIHANSISWA
        //ambildata 
        $datastagihansiswa=DB::table('tagihansiswa')
        ->get();
        foreach($datastagihansiswa as $tagihansiswa){

        $datas=DB::table('arsip_tagihansiswa')
        ->where('siswa_nis',$tagihansiswa->siswa_nis)
        ->where('tapel_nama',$tagihansiswa->tapel_nama)
        ->where('kelas_nama',$tagihansiswa->kelas_nama)
        ->count();
    
            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tagihansiswa')->insert(
                        array(
                            'tapel_nama'     =>   $tagihansiswa->tapel_nama,
                            'kelas_nama'     =>   $tagihansiswa->kelas_nama,
                            'nominaltagihan'     =>   $tagihansiswa->nominaltagihan,
                            'siswa_nis'     =>   $tagihansiswa->siswa_nis,
                            'siswa_nama'     =>   $tagihansiswa->siswa_nama,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$tagihansiswa->created_at,
                            'updated_at'=>$tagihansiswa->updated_at
                        ));
                }else{
                    arsip_tagihansiswa::where('tapel_nama',$tagihansiswa->tapel_nama)
                    ->where('siswa_nis',$tagihansiswa->siswa_nis)
                    ->where('kelas_nama',$tagihansiswa->kelas_nama)
                        ->update([
                           'nominaltagihan'     =>   $tagihansiswa->nominaltagihan,
                           'siswa_nama'     =>   $tagihansiswa->siswa_nama,
                           'updated_at'=>$tagihansiswa->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        tagihansiswa::destroy($tagihansiswa->id);

        }
        // end-DATATAGIHANSISWA


        // start-DATATAGIHANSISWADETAIL
        //ambildata 
        $datastagihansiswadetail=DB::table('tagihansiswadetail')
        ->get();
        foreach($datastagihansiswadetail as $tagihansiswadetail){

        $datas=DB::table('arsip_tagihansiswadetail')
        ->where('siswa_nis',$tagihansiswadetail->siswa_nis)
        ->where('tapel_nama',$tagihansiswadetail->tapel_nama)
        ->where('kelas_nama',$tagihansiswadetail->kelas_nama)
        ->where('created_at',$tagihansiswadetail->created_at)
        ->count();
    
            if ($datas<1) {
                    //insert data ke arsip_
                    DB::table('arsip_tagihansiswadetail')->insert(
                        array(
                            'tapel_nama'     =>   $tagihansiswadetail->tapel_nama,
                            'kelas_nama'     =>   $tagihansiswadetail->kelas_nama,
                            'nominal'     =>   $tagihansiswadetail->nominal,
                            'siswa_nis'     =>   $tagihansiswadetail->siswa_nis,
                            'siswa_nama'     =>   $tagihansiswadetail->siswa_nama,
                            'arsipkode' => $arsipkode,
                            'created_at'=>$tagihansiswadetail->created_at,
                            'updated_at'=>$tagihansiswadetail->updated_at
                        ));
                }else{
                    arsip_tagihansiswadetail::where('tapel_nama',$tagihansiswadetail->tapel_nama)
                    ->where('siswa_nis',$tagihansiswadetail->siswa_nis)
                    ->where('kelas_nama',$tagihansiswadetail->kelas_nama)
                    ->where('created_at',$tagihansiswadetail->created_at)
                        ->update([
                           'nominal'     =>   $tagihansiswadetail->nominal,
                           'siswa_nama'     =>   $tagihansiswadetail->siswa_nama,
                           'updated_at'=>$tagihansiswadetail->updated_at
                        ]);

                }
        //hapus semua data ditabel awal
        tagihansiswadetail::destroy($tagihansiswadetail->id);

        }
        // end-DATATAGIHANSISWADETAIL

        // dd($arsipkode);
        return redirect()->back()->with('status','Proses EoY berhasil!')->with('tipe','success')->with('icon','fas fa-edit');
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
