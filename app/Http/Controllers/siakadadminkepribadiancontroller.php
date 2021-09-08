<?php

namespace App\Http\Controllers;

use App\Models\kepribadian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadadminkepribadiancontroller extends Controller
{
    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadkepribadian';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kepribadian')->orderBy('nama','asc')
        ->paginate($this->paginationjml());


        // $gurus=DB::table('kepribadian')
        // ->get();

        $jmldata = DB::table('kepribadian')->count();

        return view('siakad.admin.kepribadian.index',compact('pages','jmldata','datas','request'));
        // return view('admin.beranda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required|unique:kepribadian,nama',

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
        
       
       DB::table('kepribadian')->insert(
        array(
               'nama'     =>   $request->nama,
               'tapel_nama'     =>   $this->tapelaktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    public function siakad_show(kepribadian $kepribadian)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='siakadkepribadian';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('kepribadian')
        ->paginate($this->paginationjml());


        $jmldata = DB::table('kepribadian')->count();
        return view('siakad.admin.kepribadian.edit',compact('kepribadian','pages','jmldata','datas'));
    }

    public function proses_update($request,$data)
    {
        if($request->nama!=$data->nama){
            $request->validate([
                'nama'=>'unique:kepribadian,nama',
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

        kepribadian::where('id',$data->id)
            ->update([
                'nama'=>$request->nama,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }

    public function siakad_update(Request $request, kepribadian $kepribadian)
    {
        $this->proses_update($request,$kepribadian);
            return redirect(URL::to('/').'/admin/siakadkepribadian')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        kepribadian::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }
    public function nilai(Request $request){
        // dd($kelas);
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='kepribadian';
        $jmldata='0';
        $datas='0';

        // $kepribadian=$kepribadian;

        // $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();
        // $datakepribadian=DB::table('kepribadian')->orderBy('nama','asc')->get();
        $datasiswa=DB::table('siswa')->orderBy('nama','asc')->get();

        $datakelas=DB::table('kelas')->orderBy('nama','asc')
        ->get();
        $datakepribadian=DB::table('kepribadian')->orderBy('nama','asc')
        ->get();
        // $dataguru=DB::table('guru')->orderBy('nama','asc')
        // ->get();

        
        return view('siakad.admin.inputnilai.kepribadian_index',compact('pages','jmldata','datakelas','datasiswa','datakepribadian'));
    }
}
