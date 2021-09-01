<?php

namespace App\Http\Controllers;

use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Console\Input\Input;

class tapelController extends Controller
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
        $pages='tapel';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('tapel')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('tapel')->count();

        return view('admin.tapel.index',compact('pages','jmldata','datas'));
        // return view('admin.beranda');
    }

    public function siakad_index()
    {   
      
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadtapel';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('tapel')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('tapel')->count();

        return view('siakad.admin.tapel.index',compact('pages','jmldata','datas'));
        // return view('admin.beranda');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        tapel::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tapel  $tapel
     * @return \Illuminate\Http\Response
     */

    public function siakad_show(tapel $tapel)
    {
        // dd($tapel->nama);
        // $datas = DB::table('kriteria')->where('id',$id)->get();

        #WAJIB
        $pages='siakadtapel';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('tapel')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('tapel')->count();
        return view('siakad.admin.tapel.edit',compact('tapel','pages','jmldata','datas'));
    }
    public function show(tapel $tapel)
    {
        // dd($tapel->nama);
        // $datas = DB::table('kriteria')->where('id',$id)->get();

        #WAJIB
        $pages='tapel';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('tapel')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('tapel')->count();
        return view('admin.tapel.edit',compact('tapel','pages','jmldata','datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tapel  $tapel
     * @return \Illuminate\Http\Response
     */
    public function edit(tapel $tapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tapel  $tapel
     * @return \Illuminate\Http\Response
     */
    public function proses_update($request,$tapel){

        // dd($tapel);
        
        $request->validate([
            'nama'=>'required'
        ],
        [
            'nama.required'=>'Nama Harus diisi',


        ]);
         //aksi update

        tapel::where('id',$tapel->id)
            ->update([
                'nama'=>$request->nama
            ]);
    }

    public function update(Request $request, tapel $tapel)
    {
        $this->proses_update($request,$tapel);
        
            return redirect(URL::to('/').'/admin/tapel')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function siakad_update(Request $request, tapel $tapel)
    {
        $this->proses_update($request,$tapel);
        
            return redirect(URL::to('/').'/admin/siakadtapel')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tapel  $tapel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        tapel::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
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
        tapel::whereIn('id',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='tapel';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('tapel')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('tapel')->count();

        return view('admin.tapel.index',compact('pages','jmldata','datas'));

    }
}
