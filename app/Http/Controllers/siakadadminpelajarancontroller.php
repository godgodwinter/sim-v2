<?php

namespace App\Http\Controllers;

use App\Models\kepribadian;
use App\Models\pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadadminpelajarancontroller extends Controller
{
    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadpelajaran';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pelajaran')->orderBy('tipepelajaran','asc')
        ->paginate($this->paginationjml());

        $tipepelajaran=DB::table('kategori')->where('prefix','tipepelajaran')->get();
        $jurusan=DB::table('kategori')->where('prefix','jurusan')->get();

        // $gurus=DB::table('pelajaran')
        // ->get();

        $jmldata = DB::table('pelajaran')->count();

        return view('siakad.admin.pelajaran.index',compact('pages','jmldata','datas','request','tipepelajaran','jurusan'));
        // return view('admin.beranda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required|unique:pelajaran,nama',
            'kkm' => 'required|min:1|max:100',
            'tipepelajaran' => 'required',

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);

        // dd($request->guru_nomerinduk);
        // dd($ambilnama->nama);
        //inser guru
        if(($request->tipepelajaran!='C2. Dasar Program Keahlian')&&($request->tipepelajaran!='C3. Kompetensi Keahlian')){
            $jurusan='semua';
        }else{
            $jurusan=$request->jurusan;
        }
       DB::table('pelajaran')->insert(
        array(
               'nama'     =>   $request->nama,
               'tipepelajaran'     =>   $request->tipepelajaran,
               'jurusan'     =>   $jurusan,
               'kkm'     =>   $request->kkm,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect(URL::to('/').'/admin/sync/dataajar')->with('status','Sinkronisasi Data ajar!')->with('tipe','danger')->with('icon','fas fa-trash');
        // return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function siakad_show(pelajaran $pelajaran)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='siakadpelajaran';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('pelajaran')
        ->paginate($this->paginationjml());

        $tipepelajaran=DB::table('kategori')->where('prefix','tipepelajaran')->get();
        $jurusan=DB::table('kategori')->where('prefix','jurusan')->get();

        $jmldata = DB::table('pelajaran')->count();
        return view('siakad.admin.pelajaran.edit',compact('pelajaran','pages','jmldata','datas','tipepelajaran','jurusan'));
    }

    public function proses_update($request,$kelas)
    {
        if($request->nama!=$kelas->nama){
            $request->validate([
                'nama'=>'unique:pelajaran,nama',
                'kkm' => 'required|min:1|max:100',
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
        if(($request->tipepelajaran!='C2. Dasar Program Keahlian')&&($request->tipepelajaran!='C3. Kompetensi Keahlian')){
            $jurusan='semua';
        }else{
            $jurusan=$request->jurusan;
        }

        pelajaran::where('id',$kelas->id)
            ->update([
                'nama'=>$request->nama,
                'tipepelajaran'     =>   $request->tipepelajaran,
                'jurusan'     =>   $jurusan,
                'kkm'     =>   $request->kkm,
            ]);
    }

    public function siakad_update(Request $request, pelajaran $pelajaran)
    {
        $this->proses_update($request,$pelajaran);
        return redirect(URL::to('/').'/admin/sync/dataajar')->with('status','Sinkronisasi Data ajar!')->with('tipe','danger')->with('icon','fas fa-trash');
            // return redirect(URL::to('/').'/admin/siakadpelajaran')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        pelajaran::destroy($id);
        return redirect(URL::to('/').'/admin/sync/dataajar')->with('status','Sinkronisasi Data ajar!')->with('tipe','danger')->with('icon','fas fa-trash');

        // return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');

    }

}
