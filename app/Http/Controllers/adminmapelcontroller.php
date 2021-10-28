<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminmapelcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        #WAJIB
        $pages='mapel';
        $datas=mapel::paginate(Fungsi::paginationjml());

        return view('pages.admin.mapel.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='mapel';
        $datas=DB::table('mapel')
        ->where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.mapel.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='mapel';

        $tipepelajaran=DB::table('kategori')->where('prefix','tipepelajaran')->get();

        return view('pages.admin.mapel.create',compact('pages','tipepelajaran'));
    }

    public function store(Request $request)
    {
        $cek=DB::table('mapel')
        ->where('nama',$request->nama)
        ->count();
            if($cek>0){
                    $request->validate([
                    'nama'=>'required|unique:mapel,nama',
                    ],
                    [
                        'nama.unique'=>'nama sudah digunakan',
                    ]);

            }

            $request->validate([
                'nama'=>'required',
                'kkm' => 'required|min:1|max:100',
                'tipe' => 'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            DB::table('mapel')->insert(
                array(
                        'nama'     =>   $request->nama,
                        'tipe'     =>   $request->tipe,
                        'tingkatan'     =>   $request->tingkatan,
                        'jurusan'     =>   $request->jurusan,
                        'kkm'     =>   $request->kkm,
                        'semester'     =>   $request->semester,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



                return redirect()->route('sync.mapeltodataajar')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(mapel $id)
    {
        $pages='mapel';

        $tipepelajaran=DB::table('kategori')->where('prefix','tipepelajaran')->get();
        return view('pages.admin.mapel.edit',compact('pages','id','tipepelajaran'));
    }
    public function update(mapel $id,Request $request)
    {

        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required",
            ],
            [
            ]);
        }

        $request->validate([
            'nama'=>'required',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);


        mapel::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'tipe'     =>   $request->tipe,
            'tingkatan'     =>   $request->tingkatan,
            'jurusan'     =>   $request->jurusan,
            'kkm'     =>   $request->kkm,
            'semester'     =>   $request->semester,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('sync.mapeltodataajar')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(mapel $id){

        mapel::destroy($id->id);
        return redirect()->route('mapel')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        mapel::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='mapel';
        $datas=mapel::paginate(Fungsi::paginationjml());

        return view('pages.admin.mapel.index',compact('datas','request','pages'));

    }
}
