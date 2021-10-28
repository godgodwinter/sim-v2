<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\guru;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminkelascontroller extends Controller
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
        $pages='kelas';
        $datas=kelas::with('guru')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        $guru=guru::get();

        return view('pages.admin.kelas.index',compact('datas','request','pages','guru'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='kelas';
        $datas=kelas::with('guru')
        ->where('tingkatan','like',"%".$cari."%")
        ->orWhere('jurusan','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();

        return view('pages.admin.kelas.index',compact('datas','request','pages','guru'));
    }
    public function create()
    {
        $pages='kelas';
        $walikelas=DB::table('guru')->whereNull('deleted_at')->get();
        return view('pages.admin.kelas.create',compact('pages','walikelas'));
    }

    public function store(Request $request)
    {
        // $cek=DB::table('kelas')
        // ->where('nama',$request->nama)
        // ->count();
        //     if($cek>0){
        //             $request->validate([
        //             'nama'=>'required|unique:kelas,nama',
        //             ],
        //             [
        //                 'nama.unique'=>'nama sudah digunakan',
        //             ]);

        //     }

            $request->validate([
                'tingkatan'=>'required',
                'jurusan'=>'required',

            ],
            [
                'tingkatan.nama'=>'tingkatan harus diisi',
            ]);

            DB::table('kelas')->insert(
                array(
                       'tingkatan'     =>   $request->tingkatan,
                       'jurusan'     =>   $request->jurusan,
                       'suffix'     =>   $request->suffix,
                       'guru_id'     =>   $request->guru_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



    return redirect()->route('kelas')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(kelas $id)
    {
        $pages='kelas';

        $walikelas=DB::table('guru')->whereNull('deleted_at')->get();
        return view('pages.admin.kelas.edit',compact('pages','id','walikelas'));
    }
    public function update(kelas $id,Request $request)
    {

        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required",
            ],
            [
            ]);
        }


        $request->validate([
            'tingkatan'=>'required',
            'jurusan'=>'required',

        ],
        [
            'tingkatan.nama'=>'tingkatan harus diisi',
        ]);


        kelas::where('id',$id->id)
        ->update([
            'tingkatan'     =>   $request->tingkatan,
            'jurusan'     =>   $request->jurusan,
            'guru_id'     =>   $request->guru_id,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('kelas')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(kelas $id){

        kelas::destroy($id->id);
        return redirect()->route('kelas')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        kelas::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='kelas';
        $datas=kelas::with('guru')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.kelas.index',compact('datas','request','pages'));

    }

    public function walikelasstore(kelas $id,Request $request)
    {
            $request->validate([
                'guru_id'=>'required',

            ],
            [
                'guru_id.nama'=>'tingkatan harus diisi',
            ]);


        kelas::where('id',$id->id)
        ->update([
            'guru_id'     =>   $request->guru_id,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);



    return redirect()->route('kelas')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
