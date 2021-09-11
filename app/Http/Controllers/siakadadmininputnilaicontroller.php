<?php

namespace App\Http\Controllers;

use App\Helpers\getsettings;
use App\Models\dataajar;
use App\Models\ekstrakulikuler;
use App\Models\kelas;
use App\Models\kepribadian;
use App\Models\nilaiekstrakulikuler;
use App\Models\nilaikepribadian;
use App\Models\nilaipelajaran;
use App\Models\pelajaran;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadadmininputnilaicontroller extends Controller
{
    public function mapel(dataajar $dataajar){
        // dd($kelas);
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='dataajar';
        $jmldata='0';
        $datas='0';

        $dataajar=$dataajar;

        // $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();
        $datajenisnilai=DB::table('jenisnilai')->orderBy('tipe','desc')->get();
        $jmlpengetahuan=DB::table('jenisnilai')->where('tipe','Pengetahuan')->count();
        $jmlketrampilan=DB::table('jenisnilai')->where('tipe','Ketrampilan')->count();
        $datasiswa=DB::table('siswa')->where('kelas_nama',$dataajar->kelas_nama)->orderBy('nama','asc')->get();


        $jmldata = DB::table('pelajaran')->count();
        
        return view('siakad.admin.inputnilai.index',compact('pages','jmldata','dataajar','datasiswa','datajenisnilai','jmlpengetahuan','jmlketrampilan'));
    }

    public function inputnilai(kelas $kelas){
        // dd($kelas);
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='dataajar';
        $jmldata='0';
        $datas='0';

        $kelas=$kelas;

        // $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();
        $datakepribadian=DB::table('kepribadian')->orderBy('nama','asc')->get();
        $dataekstrakulikuler=DB::table('ekstrakulikuler')->orderBy('nama','asc')->get();
        // $datajenisnilai=DB::table('jenisnilai')->orderBy('kode','asc')->get();
        $datasiswa=DB::table('siswa')->where('kelas_nama',$kelas->nama)->orderBy('nama','asc')->get();


        $jmldata = DB::table('pelajaran')->count();
        
        return view('siakad.admin.inputnilai.kepribadian_index_input',compact('pages','jmldata','kelas','datasiswa','datakepribadian','dataekstrakulikuler'));
    }
    public function lihatraport(siswa $siswa){
        // dd($kelas);
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='dataajar';
        $jmldata='0';
        $datas='0';

        // $kelas=$kelas;

        // $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();
        $datakepribadian=DB::table('kepribadian')->orderBy('nama','asc')->get();
        $dataekstrakulikuler=DB::table('ekstrakulikuler')->orderBy('nama','asc')->get();
        // $datajenisnilai=DB::table('jenisnilai')->orderBy('kode','asc')->get();
        // $datasiswa=DB::table('siswa')->where('kelas_nama',$kelas->nama)->orderBy('nama','asc')->get();


        $jmldata = DB::table('pelajaran')->count();
        
        return view('siakad.admin.inputnilai.kepribadian_index_input',compact('pages','jmldata','datakepribadian','dataekstrakulikuler'));
    }

    public function mapel_store(dataajar $dataajar,Request $request){
        // dd($dataajar);
        $request->validate([
            'nilai'=>'required|numeric|min:1|max:100',

        ],
        [
            'nilai.required'=>'nilai Harus diisi',

        ]);


    // $dataguru=DB::table('guru')
    // ->where('nomerinduk', '=', $request->guru_nomerinduk)
    // ->first();
    // dd($dataajar);
    // $guru_nama=$dataguru->nama;

    $ceknilaipelajaran=DB::table('nilaipelajaran')
    ->where('siswa_nis', '=', $request->siswa_nis)
    ->where('kelas_nama', '=', $dataajar->kelas_nama)
    ->where('jenisnilai_nama', '=', $request->jenisnilai_nama)
    ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
    ->where('semester_nama', '=', getsettings::semesteraktif())
    // ->where('guru_nama', '=', $request->guru_nama)
    ->count();
    if($ceknilaipelajaran>0){

        nilaipelajaran::where('siswa_nis',$request->siswa_nis)
        ->where('kelas_nama', '=', $dataajar->kelas_nama)
        ->where('jenisnilai_nama', '=', $request->jenisnilai_nama)
        ->where('semester_nama', '=', getsettings::semesteraktif())
        ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
            ->update([
                'nilai'=>$request->nilai,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }else{
        
       DB::table('nilaipelajaran')->insert(
        array(
               'jenisnilai_tipe'     =>   $request->jenisnilai_tipe,
               'siswa_nis'     =>   $request->siswa_nis,
               'siswa_nama'     =>   $request->siswa_nama,
               'kelas_nama'     =>   $dataajar->kelas_nama,
               'jenisnilai_nama'     =>   $request->jenisnilai_nama,
               'nilai'     =>   $request->nilai,
               'pelajaran_nama'     =>   $dataajar->pelajaran_nama,
               'guru_nama'     =>   $dataajar->guru_nama,
               'guru_nomerinduk'     =>   $dataajar->guru_nomerinduk,
               'tapel_nama'     =>   $this->tapelaktif(),
               'semester_nama'     =>   getsettings::semesteraktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
    }
        // //make response JSON
        // return response()->json([
        //     'success' => true,
        //     'message' => 'List Data Post',
        //     'data'    => $dataajar  
        // ], 200);

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    public function mapel_store_ajax(Request $request,dataajar $dataajar)
    {
        $request->validate([
            'nilai'=>'required|numeric|min:1|max:100',

        ],
        [
            'nilai.required'=>'nilai Harus diisi',

        ]);


    // $dataguru=DB::table('guru')
    // ->where('nomerinduk', '=', $request->guru_nomerinduk)
    // ->first();
    // dd($dataajar);
    // $guru_nama=$dataguru->nama;
    

    $ceknilaipelajaran=DB::table('nilaipelajaran')
    ->where('siswa_nis', '=', $request->siswa_nis)
    ->where('kelas_nama', '=', $dataajar->kelas_nama)
    ->where('jenisnilai_nama', '=', $request->jenisnilai_nama)
    ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
    ->where('semester_nama', '=', getsettings::semesteraktif())
    // ->where('guru_nama', '=', $request->guru_nama)
    ->count();
    if($ceknilaipelajaran>0){

        nilaipelajaran::where('siswa_nis',$request->siswa_nis)
        ->where('kelas_nama', '=', $dataajar->kelas_nama)
        ->where('jenisnilai_nama', '=', $request->jenisnilai_nama)
        ->where('semester_nama', '=', getsettings::semesteraktif())
        ->where('pelajaran_nama', '=', $dataajar->pelajaran_nama)
            ->update([
                'nilai'=>$request->nilai,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }else{
        
       DB::table('nilaipelajaran')->insert(
        array(
               'jenisnilai_tipe'     =>   $request->jenisnilai_tipe,
               'siswa_nis'     =>   $request->siswa_nis,
               'siswa_nama'     =>   $request->siswa_nama,
               'kelas_nama'     =>   $dataajar->kelas_nama,
               'jenisnilai_nama'     =>   $request->jenisnilai_nama,
               'nilai'     =>   $request->nilai,
               'pelajaran_nama'     =>   $dataajar->pelajaran_nama,
               'guru_nama'     =>   $dataajar->guru_nama,
               'guru_nomerinduk'     =>   $dataajar->guru_nomerinduk,
               'tapel_nama'     =>   $this->tapelaktif(),
               'semester_nama'     =>   getsettings::semesteraktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
    }
        
        // load ulang
     
   
        return response()->json(
            [
                'success' => true,
                // 'message' => 'Data inserted successfully'
                'message' => $request->nilai
            ]
        );
    }

    public function ekstra_store(ekstrakulikuler $ekstrakulikuler,kelas $kelas,siswa $siswa,Request $request){
        // dd($dataajar);
        $request->validate([
            'nilai'=>'required|numeric|min:1|max:100',

        ],
        [
            'nilai.required'=>'nilai Harus diisi',

        ]);

        // dd($ekstrakulikuler,$siswa,$kelas);
    // $dataguru=DB::table('guru')
    // ->where('nomerinduk', '=', $request->guru_nomerinduk)
    // ->first();
    // dd($dataajar);
    // $guru_nama=$dataguru->nama;

    $ceknilaiekstrakulikuler=DB::table('nilaiekstrakulikuler')
    ->where('siswa_nis', '=', $siswa->nis)
    ->where('kelas_nama', '=', $siswa->kelas_nama)
    ->where('ekstrakulikuler_nama', '=', $ekstrakulikuler->nama)
    // ->where('guru_nama', '=', $request->guru_nama)
    ->count();
    if($ceknilaiekstrakulikuler>0){

        nilaiekstrakulikuler::where('siswa_nis',$siswa->nis)
        ->where('kelas_nama', '=', $siswa->kelas_nama)
        ->where('ekstrakulikuler_nama', '=', $ekstrakulikuler->nama)
            ->update([
                'nilai'=>$request->nilai,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }else{
        
       DB::table('nilaiekstrakulikuler')->insert(
        array(
               'siswa_nis'     =>   $siswa->nis,
               'siswa_nama'     =>   $siswa->nama,
               'kelas_nama'     =>   $siswa->kelas_nama,
               'nilai'     =>   $request->nilai,
               'ekstrakulikuler_nama'     =>   $ekstrakulikuler->nama,
               'tapel_nama'     =>   $this->tapelaktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
    }

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }


    public function kepribadian_store(kepribadian $kepribadian,kelas $kelas,siswa $siswa,Request $request){
        // dd($dataajar);
        $request->validate([
            'nilai'=>'required|numeric|min:1|max:100',

        ],
        [
            'nilai.required'=>'nilai Harus diisi',

        ]);

        // dd($ekstrakulikuler,$siswa,$kelas);
    // $dataguru=DB::table('guru')
    // ->where('nomerinduk', '=', $request->guru_nomerinduk)
    // ->first();
    // dd($dataajar);
    // $guru_nama=$dataguru->nama;

    $ceknilaikepribadian=DB::table('nilaikepribadian')
    ->where('siswa_nis', '=', $siswa->nis)
    ->where('kelas_nama', '=', $siswa->kelas_nama)
    ->where('kepribadian_nama', '=', $kepribadian->nama)
    // ->where('guru_nama', '=', $request->guru_nama)
    ->count();
    if($ceknilaikepribadian>0){

        nilaikepribadian::where('siswa_nis',$siswa->nis)
        ->where('kelas_nama', '=', $siswa->kelas_nama)
        ->where('kepribadian_nama', '=', $kepribadian->nama)
            ->update([
                'nilai'=>$request->nilai,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }else{
        
       DB::table('nilaikepribadian')->insert(
        array(
               'siswa_nis'     =>   $siswa->nis,
               'siswa_nama'     =>   $siswa->nama,
               'kelas_nama'     =>   $siswa->kelas_nama,
               'nilai'     =>   $request->nilai,
               'kepribadian_nama'     =>   $kepribadian->nama,
               'tapel_nama'     =>   $this->tapelaktif(),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
    }

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    public function api_index(dataajar $dataajar)
    {
        //get data from table posts
        // $posts = Post::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $dataajar  
        ], 200);

    }

    public function api_nilaipelajaran($siswa_nis,$kelas_nama,$pelajaran_nama,$jenisnilai_nama,$semester_nama)
    {
        $ambilnilai = DB::table('nilaipelajaran')
                              ->where('siswa_nis', '=', $siswa_nis)
                              ->where('kelas_nama', '=', $kelas_nama)
                            ->where('pelajaran_nama', '=', $pelajaran_nama)
                            ->where('jenisnilai_nama', '=', $jenisnilai_nama)
                            ->where('semester_nama', '=', $semester_nama)
                              ->first();
        //get data from table posts
        // $posts = Post::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $ambilnilai  
        ], 200);

    }
}
