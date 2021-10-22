<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class admintapelcontroller extends Controller
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
        $pages='tapel';
        $datas=DB::table('tapel')
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.tapel.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='tapel';
        $datas=DB::table('tapel')
        ->where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.tapel.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='tapel';

        return view('pages.admin.tapel.create',compact('pages'));
    }

    public function store(Request $request)
    {
        $cek=DB::table('tapel')
        ->where('nama',$request->nama)
        ->count();
            if($cek>0){
                    $request->validate([
                    'nama'=>'required|unique:tapel,nama',
                    ],
                    [
                        'nama.unique'=>'nama sudah digunakan',
                    ]);

            }

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            DB::table('tapel')->insert(
                array(
                       'nama'     =>   $request->nama,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



    return redirect()->route('tapel')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(tapel $id)
    {
        $pages='tapel';

        return view('pages.admin.tapel.edit',compact('pages','id'));
    }
    public function update(tapel $id,Request $request)
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


        tapel::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('tapel')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(tapel $id){

        tapel::destroy($id->id);
        return redirect()->route('tapel')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        tapel::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='tapel';
        $datas=DB::table('tapel')
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.tapel.index',compact('datas','request','pages'));

    }
}
