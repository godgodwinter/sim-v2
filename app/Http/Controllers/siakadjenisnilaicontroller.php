<?php

namespace App\Http\Controllers;

use App\Models\jenisnilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadjenisnilaicontroller extends Controller
{
    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadjenisnilai';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('jenisnilai')
        ->paginate($this->paginationjml());

        // $gurus=DB::table('jenisnilai')
        // ->get();

        $jmldata = DB::table('jenisnilai')->count();

        return view('siakad.admin.jenisnilai.index',compact('pages','jmldata','datas','request'));
        // return view('admin.beranda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required|unique:jenisnilai,nama'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
        
        // dd($request->guru_nomerinduk);
        // dd($ambilnama->nama);
        //inser guru
       DB::table('jenisnilai')->insert(
        array(
               'nama'     =>   $request->nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    public function siakad_show(jenisnilai $jenisnilai)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='siakadjenisnilai';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('jenisnilai')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('jenisnilai')->count();
        return view('siakad.admin.jenisnilai.edit',compact('jenisnilai','pages','jmldata','datas'));
    }

    public function proses_update($request,$kelas)
    {
        if($request->nama!==$kelas->nama){
            $request->validate([
                'nama'=>'unique:jenisnilai,nama'
            ],
            [
                // 'nama.unique'=>'Nama harus diisi'


            ]);
        }

        $request->validate([
            'nama'=>'required'
        ],
        [
            'nama.required'=>'Nama harus diisi'


        ]);


         //aksi update

        jenisnilai::where('id',$kelas->id)
            ->update([
                'nama'=>$request->nama,
            ]);
    }

    public function siakad_update(Request $request, jenisnilai $jenisnilai)
    {
        $this->proses_update($request,$jenisnilai);
            return redirect(URL::to('/').'/admin/siakadjenisnilai')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        jenisnilai::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }
}
