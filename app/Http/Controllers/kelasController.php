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
    public function index(Request $request)
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

        $gurus=DB::table('guru')
        ->get();

        $jmldata = DB::table('kelas')->count();

        return view('admin.kelas.index',compact('pages','jmldata','datas','request','gurus'));
        // return view('admin.beranda');
    }


    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadkelas';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());

        $gurus=DB::table('guru')
        ->get();

        $jmldata = DB::table('kelas')->count();

        return view('siakad.admin.kelas.index',compact('pages','jmldata','datas','request','gurus'));
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
        // dd($request);
        $request->validate([
            'nama'=>'required|unique:kelas,nama'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
            // dd($request);
        $guru_nama='';
        $cekambilnama=DB::table('guru')->where('nomerinduk',$request->guru_nomerinduk)
        ->count();
        if($cekambilnama>0){
            $ambilnama=DB::table('guru')->where('nomerinduk',$request->guru_nomerinduk)
            ->first();
            if($ambilnama->nama!==null){
                $guru_nama=$ambilnama->nama;
            }
        }

        // dd($request->guru_nomerinduk);
        // dd($ambilnama->nama);
        //inser guru
       DB::table('kelas')->insert(
        array(
               'nama'     =>   $request->nama,
               'guru_nomerinduk'     =>   $request->guru_nomerinduk,
               'guru_nama'     =>   $guru_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect(URL::to('/').'/admin/sync/dataajar')->with('status','Sinkronisasi Data ajar!')->with('tipe','danger')->with('icon','fas fa-trash');
        // return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

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

        $gurus=DB::table('guru')
        ->get();

        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('kelas')->count();
        return view('admin.kelas.edit',compact('kelas','pages','jmldata','datas','gurus'));
    }

    public function siakad_show(kelas $kelas)
    {
        // $kela lihat di route:list
        // $kelas=$kelas;

        #WAJIB
        $pages='siakadkelas';
        $jmldata='0';
        $datas='0';

        $gurus=DB::table('guru')
        ->get();

        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());
        $jmldata = DB::table('kelas')->count();
        return view('siakad.admin.kelas.edit',compact('kelas','pages','jmldata','datas','gurus'));
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
    public function proses_kelas($request,$kelas)
    {
        if($request->nama!==$kelas->nama){
            $request->validate([
                'nama'=>'unique:kelas,nama'
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

        $guru_nomerinduk='';
        $guru_nama='';
        // dd($request->guru_nomerinduk);
        if($request->guru_nomerinduk!==null){
            $ambilnama=DB::table('guru')->where('nomerinduk',$request->guru_nomerinduk)
            ->first();

            if($ambilnama->nama!==null){
                $guru_nomerinduk=$ambilnama->nomerinduk;
                $guru_nama=$ambilnama->nama;
            }
        }

         //aksi update

        kelas::where('id',$kelas->id)
            ->update([
                'nama'=>$request->nama,
                'guru_nomerinduk'=>$guru_nomerinduk,
                'guru_nama'=>$guru_nama,
            ]);
    }
    public function update(Request $request, kelas $kela)
    {
        $kelas=$kela;
        // dd($kelas->id);
        $this->proses_kelas($request,$kelas);

        return redirect(URL::to('/').'/admin/sync/dataajar')->with('status','Sinkronisasi Data ajar!')->with('tipe','danger')->with('icon','fas fa-trash');
            // return redirect(URL::to('/').'/admin/kelas')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function siakad_update(Request $request, kelas $kelas)
    {
        $this->proses_kelas($request,$kelas);
            return redirect(URL::to('/').'/admin/siakadkelas')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas=DB::table('kelas')->where('id',$id)->first();
        $kelas_nama=$kelas->nama;
        DB::table('dataajar')->where('kelas_nama', $kelas_nama)->delete();
        kelas::destroy($id);
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
