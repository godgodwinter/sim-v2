<?php

namespace App\Http\Controllers;

use App\Models\ekstrakulikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadadminekstrakulikulercontroller extends Controller
{
    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadekstrakulikuler';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('ekstrakulikuler')->orderBy('nama','asc')
        ->paginate($this->paginationjml());


        // $gurus=DB::table('ekstrakulikuler')
        // ->get();

        $jmldata = DB::table('ekstrakulikuler')->count();

        return view('siakad.admin.ekstrakulikuler.index',compact('pages','jmldata','datas','request'));
        // return view('admin.beranda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required|unique:ekstrakulikuler,nama',

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
        
       
       DB::table('ekstrakulikuler')->insert(
        array(
               'nama'     =>   $request->nama,
               'tapel_nama'     =>   $this->tapelaktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    public function siakad_show(ekstrakulikuler $ekstrakulikuler)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='siakadekstrakulikuler';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('ekstrakulikuler')
        ->paginate($this->paginationjml());


        $jmldata = DB::table('ekstrakulikuler')->count();
        return view('siakad.admin.ekstrakulikuler.edit',compact('ekstrakulikuler','pages','jmldata','datas'));
    }

    public function proses_update($request,$data)
    {
        if($request->nama!=$data->nama){
            $request->validate([
                'nama'=>'unique:ekstrakulikuler,nama',
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

        ekstrakulikuler::where('id',$data->id)
            ->update([
                'nama'=>$request->nama,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }

    public function siakad_update(Request $request, ekstrakulikuler $ekstrakulikuler)
    {
        $this->proses_update($request,$ekstrakulikuler);
            return redirect(URL::to('/').'/admin/siakadekstrakulikuler')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        ekstrakulikuler::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }

    public function nilai(Request $request){
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='ekstrakulikuler';
        $jmldata='0';
        $datas='0';

        $datakelas=DB::table('kelas')->orderBy('nama','asc')
        ->get();
        $dataekstrakulikuler=DB::table('ekstrakulikuler')->orderBy('nama','asc')
        ->get();

        
        return view('siakad.admin.inputnilai.ekstrakulikuler_index',compact('pages','jmldata','datakelas','dataekstrakulikuler'));
    }
}
