<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class synccontroller extends Controller
{
    public function dataajar(){
        // 1. ambil pelajaran
        $pelajaran=DB::table('pelajaran')
                    ->get();

        // 2. ambil kelas
        $kelas=DB::table('kelas')
        ->get();
        // dd('sync');
        foreach($pelajaran as $p){
            foreach($kelas as $k){
                $kodekelas=Fungsi::periksajurusankode($k->nama);
                if(($p->tipepelajaran!='C2. Dasar Program Keahlian')&&($p->tipepelajaran!='C3. Kompetensi Keahlian')){
                    $jurusan='semua';
                }else{
                    $jurusan=$p->jurusan;
                }
                // 3. ambiljmldata pada tabel dataajar
                    if(($p->jurusan==Fungsi::periksajurusankode($k->nama))||($p->jurusan=='semua')){


                                $ambildataajar=DB::table('dataajar')
                                                ->where('pelajaran_nama',$p->nama)
                                                ->where('kelas_nama',$k->nama)
                                                ->count();
                                if($ambildataajar>0){
                                    //update
                                        // dataajar::where('pelajaran_nama',$p->nama)
                                        //         ->where('kelas_nama',$k->nama)
                                        //     ->update([
                                        //         'guru_nomerinduk'=>$request->guru_nomerinduk,
                                        //         'guru_nama'     =>   $guru_nama,
                                        //         'updated_at'=>date("Y-m-d H:i:s")
                                        //     ]);
                                }else{
                                    // insert
                                        DB::table('dataajar')->insert(
                                            array(
                                                'pelajaran_nama'     =>   $p->nama,
                                                'pelajaran_tipepelajaran'     =>   $p->tipepelajaran,
                                                'pelajaran_jurusan'     =>   $kodekelas,
                                                'kelas_nama'     =>   $k->nama,
                                                'created_at'=>date("Y-m-d H:i:s"),
                                                'updated_at'=>date("Y-m-d H:i:s")
                                            ));
                                }

                    }else{

                    }


                // 3.1 insert sesuai fungsi jurusan


            }

        }

        // 1 periksa jika tidak ada di pelajaran dan nama maka hapus

        $dataajar=DB::table('dataajar')
                    ->get();
        $pelajaran=DB::table('pelajaran')
                    ->get();
        $kelas=DB::table('kelas')
                    ->get();
        foreach($dataajar as $da){
            $cek=0;
            foreach($pelajaran as $p){
                    if($da->pelajaran_nama==$p->nama){
                        $cek++;
                    }
            }
            if($cek==0){
                // hapus
                dataajar::destroy($da->id);

            }

            $cek=0;
            foreach($kelas as $k){
                    if($da->kelas_nama==$k->nama){
                        $cek++;
                    }
            }
            if($cek==0){
                // hapus
                dataajar::destroy($da->id);

            }
        }
        return redirect()->back()->with('status','Data berhasil di sinkronisasi!')->with('tipe','success')->with('icon','fas fa-feather');
        // dd($jurusan,$ambildataajar,$k->nama);

        // 4. jika ada skip
    }
}
