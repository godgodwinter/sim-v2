<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\kompetensidasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class gurukompetensidasarcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(dataajar $dataajar, Request $request)
    {
        $guru_id=guru::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
        #WAJIB
        $pages='silabus';
        $datas=kompetensidasar::with('dataajar')->with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.admin.kompetensidasar.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='silabus';

        return view('pages.admin.kompetensidasar.create',compact('request','pages','dataajar'));
    }
    public function store(dataajar $dataajar,Request $request){
        // dd($request,$dataajar);
        $cek=kompetensidasar::where('nama',$request->nama)
        ->where('kode',$request->kode)
        ->where('tipe',$request->tipe)
        ->where('dataajar_id',$dataajar->id)
        ->count();

        if($cek>0){

        }else{
            DB::table('kompetensidasar')->insert(
                array(
                       'nama'     =>   $request->nama,
                       'kode'     =>   $request->kode,
                       'tipe'     =>   $request->tipe,
                       'dataajar_id'     =>   $dataajar->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));
        return redirect()->route('dataajar.kompetensidasar',$dataajar->id)->with('status','Data berhasil di tambah!')->with('tipe','success');
        }

    }
    public function edit(dataajar $dataajar,kompetensidasar $id, Request $request)
    {
        #WAJIB
        $pages='silabus';

        return view('pages.admin.kompetensidasar.edit',compact('request','pages','dataajar','id'));
    }
    public function update(dataajar $dataajar,kompetensidasar $id,Request $request)
    {

        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required",
            ],
            [
            ]);
        }



        kompetensidasar::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'tipe'     =>   $request->tipe,
            'kode'     =>   $request->kode,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('dataajar.kompetensidasar',$dataajar->id)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(dataajar $dataajar,kompetensidasar $id){

        kompetensidasar::destroy($id->id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }
    public function multidel(dataajar $dataajar, Request $request)
    {

        $ids=$request->ids;
        kompetensidasar::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='silabus';
        $datas=kompetensidasar::with('dataajar')->with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.admin.kompetensidasar.index',compact('datas','request','pages','dataajar'));

    }
}
