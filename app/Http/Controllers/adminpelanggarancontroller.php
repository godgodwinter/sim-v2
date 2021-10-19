<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminpelanggarancontroller extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        #WAJIB
        $pages='pelanggaran';
        $datas=DB::table('pelanggaran')
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pelanggaran.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        $cari=$request->cari;
        #WAJIB
        $pages='pelanggaran';
        $datas=DB::table('pelanggaran')

        ->where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pelanggaran.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='pelanggaran';

        return view('pages.admin.pelanggaran.create',compact('pages'));
    }

    public function store(Request $request)
    {
        $cek=DB::table('pelanggaran')->where('nama',$request->nama)->count();
        // dd($cek);
            if($cek>0){
                    $request->validate([
                    'nama'=>'required|unique:pelanggaran,nama',

                    ],
                    [
                        'nama.unique'=>'Nama sudah digunakan',
                    ]);

            }

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);


        //inser siswa
        DB::table('pelanggaran')->insert(
            array(
                   'nama'     =>   $request->nama,
                   'point'     =>   $request->point,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));

    return redirect()->route('pelanggaran')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(pelanggaran $id)
    {

        $pages='pelanggaran';

        return view('pages.admin.pelanggaran.edit',compact('pages','id'));
    }
    public function update(pelanggaran $id,Request $request)
    {
        // dd($request);
        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required|unique:pelanggaran,nama,".$request->nama,
            ],
            [
                'nama.unique'=>'Nama sudah digunakan',
            ]);
        }


        $request->validate([
            'nama'=>'required',
            // 'pelanggaran_logo' => 'require|image',
        ],
        [
            'nama.required'=>'nama sudah digunakan',
        ]);



        pelanggaran::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'point'     =>   $request->point,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);




    return redirect()->back()->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(pelanggaran $id){

        pelanggaran::destroy($id->id);
        return redirect()->route('pelanggaran')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        pelanggaran::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='pelanggaran';
        $datas=DB::table('pelanggaran')
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pelanggaran.index',compact('datas','request','pages'))->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

}
