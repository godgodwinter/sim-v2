<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\tagihanatur;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class tagihanaturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='tagihanatur';
        $jmldata='0';
        $datas='0';


        $tapel=tapel::all();
        $kelas=kelas::all();
        $datas=DB::table('tagihanatur')->orderBy('tapel_nama','asc')
        ->paginate($this->paginationjml());
        // // $tagihanatur=tagihanatur::all();
        // $tagihanatur = DB::table('tagihanatur')->where('prefix','tagihanatur')->get();
        $jmldata = DB::table('tagihanatur')->count();

        return view('admin.tagihanatur.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }
    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;

        #WAJIB
        $pages='tagihanatur';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('tagihanatur')
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('tagihanatur')->count();


        return view('admin.tagihanatur.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'tapel_nama'=>'required',
            'kelas_nama'=>'required',
            'nominaltagihan'=>'required|numeric'

        ],
        [
            'tapel_nama.required'=>'tapel_nama Harus diisi',
            'kelas_nama.required'=>'kelas_nama Harus diisi',
            'nominaltagihan.required'=>'nominaltagihan Harus diisi',

        ]);

        //jika kelas dan nama sudah ada maka edit
        $cek1 = DB::table('tagihanatur')
        ->where('kelas_nama',$request->kelas_nama)
        ->where('tapel_nama',$request->tapel_nama)
        ->count();
        // dd($cek1);

        //jika sudah ada maka edit
        if($cek1>0){
            tagihanatur::where('kelas_nama',$request->kelas_nama)->where('tapel_nama',$request->tapel_nama)
                ->update([
                    'nominaltagihan'=>$request->nominaltagihan
                ]);

        }else{
            tagihanatur::create($request->all());
        }


        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tagihanatur  $tagihanatur
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,tagihanatur $tagihanatur)
    {
        #WAJIB
        $pages='tagihanatur';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('tagihanatur')->orderBy('tapel_nama','asc')
        ->paginate($this->paginationjml());
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('tagihanatur')->count();
        return view('admin.tagihanatur.edit',compact('tagihanatur','pages','jmldata','datas','tapel','kelas','request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihanatur  $tagihanatur
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihanatur $tagihanatur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihanatur  $tagihanatur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihanatur $tagihanatur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihanatur  $tagihanatur
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihanatur $tagihanatur)
    {
        tagihanatur::destroy($tagihanatur->id);
        return redirect(URL::to('/').'/admin/tagihanatur')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }
}
