<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\banksoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;

class banksoalcontroller extends Controller
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
        $pages='banksoal';
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

        // $datas=$datastanpauniq->unique('kode');



        $generate_kode=Fungsi::kompetensidasargeneratekode();


        // 1. ambil datas dari tabel kompetensi dasar where tapel kelas dan pelajarannama
        // 1. ambil last id (Fungsi generatekompetesiid)


        return view('admin.banksoal.index',compact('pages','datas','request','kodegenerate','pelajaran_nama','kelas_nama','tapel_nama'
        ,'materipokok_nama'
        ,'kompetensidasar_kode'
        ,'kompetensidasar_tipe'
    ));

    }
    //


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

        $kodegenerate=Uuid::uuid4()->getHex();

    //    dd($request->tingkatkesulitan);

       DB::table('banksoal')->insert(
        array(
               'pertanyaan'     =>   $request->pertanyaan,
               'nilai'     =>   100,
               'tingkatkesulitan'     =>   $request->tingkatkesulitan,
               'tingkatkesulitanangka'     =>   0,
               'kodegenerate'     =>   $kodegenerate,
               'kompetensidasar_tipe'     =>   $kd_tipe,
               'materipokok_nama'     =>   $mp_nama,
               'kompetensidasar_kode'     =>   $kd_kode,
               'pelajaran_nama'     =>   $p_nama,
               'kelas_nama'     =>   $k_nama,
               'tapel_nama'     =>   $t_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');


    }
    public function show(banksoal $id)
    {
        // dd($id);
        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas=$id;


        // $datas=DB::table('kategori')->orderBy('prefix','asc')->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        // $jmldata = DB::table('kategori')->count();

        return view('admin.banksoal.edit',compact('pages','datas'));
    }

    public function detail(banksoal $id)
    {
        // dd($id);
        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas=$id;


        // $datas=DB::table('kategori')->orderBy('prefix','asc')->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        // $jmldata = DB::table('kategori')->count();

        return view('admin.banksoal.detail',compact('pages','datas'));
    }

    public function proses_update($request,$id){

        // dd($tapel);

        $request->validate([
            'pertanyaan'=>'required'
        ],
        [
            'pertanyaan.required'=>'pertanyaan Harus diisi',


        ]);
         //aksi update

        banksoal::where('id',$id->id)
            ->update([
                'pertanyaan'=>$request->pertanyaan,
                'tingkatkesulitan'=>$request->tingkatkesulitan,
            ]);
    }

    public function update(Request $request, banksoal $id)
    {
        // dd($request);
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        banksoal::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    }
}
