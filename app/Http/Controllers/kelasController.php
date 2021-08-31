<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class kelasController extends Controller
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
        $pages='kelas';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());

        $jmldata = DB::table('kelas')->count();

        return view('admin.kelas.index',compact('pages','jmldata','datas'));
        // return view('admin.beranda');
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
            'nama'=>'required'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
            // dd($request);
        kelas::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(kelas $kela)
    {
        // $kela lihat di route:list
        $kelas=$kela;

        #WAJIB
        $pages='kelas';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('kelas')->count();
        return view('admin.kelas.edit',compact('kelas','pages','jmldata','datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(kelas $kela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kelas $kela)
    {
        $kelas=$kela;
        // dd($kelas->id);

        $request->validate([
            'nama'=>'required'
        ],
        [
            'nama.required'=>'Nama harus diisi'


        ]);
         //aksi update

        kelas::where('id',$kelas->id)
            ->update([
                'nama'=>$request->nama
            ]);
            return redirect(URL::to('/').'/admin/kelas')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        kelas::destroy($id);
        return redirect(URL::to('/').'/admin/kelas')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }

    public function deletechecked(Request $request)
    {
        
        $ids=$request->ids;

        // $datasiswa = DB::table('siswa')->where('id',$ids)->get();
        // foreach($datasiswa as $ds){
        //     $nis=$ds->nis;
        // }

        // dd($request);

        // DB::table('tagihansiswa')->where('siswa_nis', $ids)->where('tapel_nama',$this->tapelaktif())->delete();
        kelas::whereIn('id',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='kelas';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());

        $jmldata = DB::table('kelas')->count();

        return view('admin.kelas.index',compact('pages','jmldata','datas'));

    }
}
