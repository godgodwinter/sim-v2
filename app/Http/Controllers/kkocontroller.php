<?php

namespace App\Http\Controllers;

use App\Models\kko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class kkocontroller extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='kko';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kko')->orderBy('nama','asc')
        ->paginate($this->paginationjml());


        return view('admin.kko.index',compact('pages','datas','request'));
        // return view('admin.beranda');
    }
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama'=>'required|unique:kko,nama'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);


        // dd($request->guru_nomerinduk);
        // dd($ambilnama->nama);
        //inser guru
       DB::table('kko')->insert(
        array(
               'nama'     =>   $request->nama,
               'tipe'     =>   $request->tipe,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
    public function show(kko $id)
    {
        // $kela lihat di route:list
        #WAJIB
        $pages='kko';
        $jmldata='0';
        $kko=$id;


        $datas=DB::table('kko')
        ->paginate($this->paginationjml());
        return view('admin.kko.edit',compact('pages','datas','kko'));
    }
    public function proses_update($request,$id)
    {
            $request->validate([
                'nama'=>'unique:kko,nama'
            ],
            [
                // 'nama.unique'=>'Nama harus diisi'


            ]);
        $request->validate([
            'nama'=>'required'
        ],
        [
            'nama.required'=>'Nama harus diisi'


        ]);

         //aksi update

        kko::where('id',$id->id)
            ->update([
                'nama'=>$request->nama,
                'tipe'=>$request->nama,
            ]);
    }
    public function update(Request $request, kko $id)
    {
        $this->proses_update($request,$id);

            return redirect(URL::to('/').'/admin/kko')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function destroy($id)
    {
        kko::destroy($id);
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
        kko::whereIn('id',$ids)->delete();


        // load ulang

        #WAJIB
        $pages='kko';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kko')
        ->paginate($this->paginationjml());


        return view('admin.kko.index',compact('pages','datas'));

    }

}
