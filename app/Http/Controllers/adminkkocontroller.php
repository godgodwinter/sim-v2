<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kko;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminkkocontroller extends Controller
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
        $pages='kko';
        $datas=kko::paginate(Fungsi::paginationjml());

        // dd($datas);

        return view('pages.admin.kko.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='kko';
        $datas=DB::table('kko')
        ->where('nama','like',"%".$cari."%")

        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.kko.index',compact('datas','request','pages'));
    }


    public function create()
    {
        $pages='kko';


        return view('pages.admin.kko.create',compact('pages'));
    }

    public function store(Request $request)
    {
        // dd($request);

        $request->validate([

            'nama'=>'required',



        ],
        [


        ]);


        //insert users
       DB::table('kko')->insert(
        array(

               'nama'     =>   $request->nama,
               'tipe'     =>   $request->tipe,
               'keterangan'     =>   $request->keterangan,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));



    return redirect()->route('kko')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(kko $id)
    {
        $pages='kko';




        return view('pages.admin.kko.edit',compact('pages','id'));
    }
    public function update(kko $id,Request $request)
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


            kko::where('id',$id->id)
            ->update([
                'nama'     =>   $request->nama,
               'tipe'     =>   $request->tipe,
               'keterangan'     =>   $request->keterangan,

               'updated_at'=>date("Y-m-d H:i:s")
            ]);

    return redirect()->route('kko')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(kko $id){

        kko::destroy($id->id);
        return redirect()->route('kko')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        kko::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='kko';
        $datas=DB::table('kko')
        ->paginate(Fungsi::paginationjml());
        return view('pages.admin.kko.index',compact('datas','request','pages'));

    }
}
