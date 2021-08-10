<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class kategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='kategori';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kategori')->orderBy('prefix','asc')->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        $jmldata = DB::table('kategori')->count();

        return view('admin.kategori.index',compact('pages','jmldata','datas'));
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
            'nama'=>'required',
            'prefix'=>'required'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
            // dd($request);
        kategori::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(kategori $kategori)
    {
        #WAJIB
        $pages='kategori';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kategori')->orderBy('prefix','asc')->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        $jmldata = DB::table('kategori')->count();

        return view('admin.kategori.edit',compact('pages','jmldata','datas','kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kategori $kategori)
    {
        // dd($tapel);
        
        $request->validate([
            'nama'=>'required'
        ],
        [
            'nama.required'=>'Nama Harus diisi',


        ]);
         //aksi update

        kategori::where('id',$kategori->id)
            ->update([
                'nama'=>$request->nama,
                'prefix'=>$request->prefix,
            ]);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(kategori $kategori)
    {
        kategori::destroy($kategori->id);
        return redirect(URL::to('/').'/admin/kategori')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }
}
