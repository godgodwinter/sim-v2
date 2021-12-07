<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\mapel;
use App\Models\tagihan;
use App\Models\tagihandetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminsynccontroller extends Controller
{
    public function mapeltodataajar(Request $request){
        // 1. ambil semua mapel pada semester ini
        $ambilmapel=mapel::get();
        foreach($ambilmapel as $m){
            // 2. ambil kelas sesuai mapel tersebut
            $ambildatakelas=kelas::get();

                // 2.1 periksa tingkatan
            if($m->tingkatan!='Semua'){
                $periksatingkatan=$ambildatakelas->where('tingkatan',$m->tingkatan);
            }else{
                $periksatingkatan=$ambildatakelas;
            }
            // dd($ambilmapel,$periksatingkatan);
                // 2.2 periksa jurusan
            if($m->jurusan!='Semua'){
                $periksajurusan=$periksatingkatan->where('jurusan',$m->jurusan);
            }else{
                $periksajurusan=$periksatingkatan;
            }

            // dd($ambilmapel,$periksatingkatan,$periksajurusan);

        // 3. Insert kedalam dataajar
        foreach($periksajurusan as $datahasilperiksa){
            // cek jiksa sudah ada maka update jika belum maka insert
            $cek=DB::table('dataajar')
            ->where('mapel_id',$m->id)
            ->where('kelas_id',$datahasilperiksa->id)
            ->count();
            if($cek>0){
                // update
                    // mapel::where('id',$id->id)
                    // ->update([
                    //     'nama'     =>   $request->nama,
                    //     'tipe'     =>   $request->tipe,
                    //     'tingkatan'     =>   $request->tingkatan,
                    //     'jurusan'     =>   $request->jurusan,
                    //     'kkm'     =>   $request->kkm,
                    //     'semester'     =>   $request->semester,
                    // 'updated_at'=>date("Y-m-d H:i:s")
                    // ]);
            }else{
                // insert
                    DB::table('dataajar')->insert(
                        array(
                                'nama'     =>   $m->nama,
                                'kelas_id'     =>   $datahasilperiksa->id,
                                'mapel_id'     =>   $m->id,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                        ));
            }
        }

        $cekdataajar=DB::table('dataajar')->get();


// $collection = collect([1, 2, 3, 4, 5,6,7]);

// $diff = $collection->diff([1, 2,10]);

// $diff->all();

$periksaperludihapus=$cekdataajar->pluck('kelas_id')->diff($periksajurusan->pluck('id'));

foreach($periksaperludihapus as $h){
    // dd($h);
    DB::table('dataajar')->where('mapel_id',$m->id)->where('kelas_id',$h)->delete();
}


            // dd($periksaperludihapus,$m->nama,$periksajurusan->pluck('id'),$cekdataajar->pluck('kelas_id'));
        }
        //tutup mapel
        // dd($ambildatakelas->where('tingkatan','=','X'));
    return redirect()->back()->with('status','Data berhasil disinkron ke dataajar!')->with('tipe','success')->with('icon','fas fa-feather');

    }


    public function tagihantodetail(Request $request){
        // dd('test');
        // 1. ambil semua mapel pada semester ini
        $ambiltagihan=tagihan::get();
        foreach($ambiltagihan as $m){
            // 2. ambil kelas sesuai mapel tersebut
            $ambildatakelas=kelas::get();

                // 2.1 periksa tingkatan
            if($m->tingkatan!='Semua'){
                $periksatingkatan=$ambildatakelas->where('tingkatan',$m->tingkatan);
            }else{
                $periksatingkatan=$ambildatakelas;
            }
            // dd($ambiltagihan,$periksatingkatan);
                // 2.2 periksa jurusan
            if($m->jurusan!='Semua'){
                $periksajurusan=$periksatingkatan->where('jurusan',$m->jurusan);
            }else{
                $periksajurusan=$periksatingkatan;
            }

            // dd($ambiltagihan,$periksatingkatan,$periksajurusan);

        // 3. Insert kedalam dataajar
        foreach($periksajurusan as $datahasilperiksa){
            // cek jiksa sudah ada maka update jika belum maka insert
            $cek=tagihandetail
            ::where('tagihan_id',$m->id)
            ->where('kelas_id',$datahasilperiksa->id)
            ->count();
            if($cek>0){
                // update
                    // mapel::where('id',$id->id)
                    // ->update([
                    //     'nama'     =>   $request->nama,
                    //     'tipe'     =>   $request->tipe,
                    //     'tingkatan'     =>   $request->tingkatan,
                    //     'jurusan'     =>   $request->jurusan,
                    //     'kkm'     =>   $request->kkm,
                    //     'semester'     =>   $request->semester,
                    // 'updated_at'=>date("Y-m-d H:i:s")
                    // ]);
            }else{
                // insert
                    tagihandetail::insert(
                        array(
                                'nama'     =>   $m->nama,
                                'kelas_id'     =>   $datahasilperiksa->id,
                                'tagihan_id'     =>   $m->id,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                        ));
            }
        }

        $cektagihandetail=tagihandetail::get();


// $collection = collect([1, 2, 3, 4, 5,6,7]);

// $diff = $collection->diff([1, 2,10]);

// $diff->all();

$periksaperludihapus=$cektagihandetail->pluck('kelas_id')->diff($periksajurusan->pluck('id'));

foreach($periksaperludihapus as $h){
    // dd($h);
    tagihandetail::where('tagihan_id',$m->id)->where('kelas_id',$h)->delete();
}


            // dd($periksaperludihapus,$m->nama,$periksajurusan->pluck('id'),$cektagihandetail->pluck('kelas_id'));
        }
        //tutup mapel
        // dd($ambildatakelas->where('tingkatan','=','X'));
    return redirect()->route('tagihan')->with('status','Data berhasil disinkron ke kelas terpilih!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
