<?php

namespace App\Http\Controllers;

use App\Models\dataajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class siakadadmindataajarcontroller extends Controller
{
    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakaddataajar';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('dataajar')
        ->orderBy('kelas_nama','asc')
        // ->orderBy('pelajaran_jurusan','desc')
        ->paginate($this->paginationjml());

        $kelas=DB::table('kelas')->get();
        $pelajaran=DB::table('pelajaran')->get();
        $dataguru=DB::table('guru')->get();
        return view('siakad.admin.dataajar.index',compact('datas','pages','request','kelas','pelajaran','dataguru'));
    }
    public function siakad_index_cari (Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        $pelajaran_nama=$request->pelajaran_nama;
        $kelas_nama=$request->kelas_nama;
        // dd($request);
        #WAJIB
        $pages='siakaddataajar';
        $jmldata='0';
        $datas='0';

        $datas=DB::table('dataajar')
        // ->where('nis','like',"%".$cari."%")
        // ->where('nama','like',"%".$cari."%")
        ->where('pelajaran_nama','like',"%".$pelajaran_nama."%")
        ->where('kelas_nama','like',"%".$kelas_nama."%")
        ->orderBy('kelas_nama','asc')
        ->paginate($this->paginationjml());


        // $datas=DB::table('dataajar')
        // ->orderBy('kelas_nama','asc')
        // // ->orderBy('pelajaran_jurusan','desc')
        // ->paginate($this->paginationjml());

        $kelas=DB::table('kelas')->get();
        $pelajaran=DB::table('pelajaran')->get();
        $dataguru=DB::table('guru')->get();
        return view('siakad.admin.dataajar.index',compact('datas','pages','request','kelas','pelajaran','dataguru'));
    }
    public function siakad_index_old(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakaddataajar';
        $jmldata='0';
        $datas='0';


        // $datas=DB::table('dataajar')->orderBy('tipepelajaran','asc')
        // ->paginate($this->paginationjml());

        // $datas=DB::table('kelas')
        // ->select('pelajaran.nama','kelas.nama','pelajaran.jurusan')
        // ->join('profiles','profiles.id','=','users.id')
        // ->where(['something' => 'something', 'otherThing' => 'otherThing'])
        // ->get();

        // dd($datas);
        $datakelas=DB::table('kelas')->orderBy('nama','asc')
        ->get();
        $datapelajaran=DB::table('pelajaran')->orderBy('tipepelajaran','asc')
        ->get();
        $dataguru=DB::table('guru')->orderBy('nama','asc')
        ->get();

        $tipepelajaran=DB::table('kategori')->where('prefix','prefix')->get();
        $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();

        // $gurus=DB::table('pelajaran')
        // ->get();

        $jmldata = DB::table('pelajaran')->count();

        return view('siakad.admin.dataajar.index_old',compact('datas','pages','jmldata','datakelas','request','tipepelajaran','jurusan','datapelajaran','dataguru'));
        // return view('admin.beranda');
    }
    // public function siakad_index(Request $request)
    // {
    //     if($this->checkauth('admin')==='404'){
    //         return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
    //     }
    //     #WAJIB
    //     $pages='siakaddataajar';
    //     $jmldata='0';
    //     $datas='0';


    //     // $datas=DB::table('dataajar')->orderBy('tipepelajaran','asc')
    //     // ->paginate($this->paginationjml());

    //     $datakelas=DB::table('kelas')->orderBy('nama','asc')
    //     ->get();
    //     $datapelajaran=DB::table('pelajaran')->orderBy('tipepelajaran','asc')
    //     ->get();
    //     $dataguru=DB::table('guru')->orderBy('nama','asc')
    //     ->get();

    //     $tipepelajaran=DB::table('kategori')->where('prefix','prefix')->get();
    //     $jurusan=DB::table('kategori')->where('prefix','jurusan')->orderBy('prefix','asc')->get();

    //     // $gurus=DB::table('pelajaran')
    //     // ->get();

    //     $jmldata = DB::table('pelajaran')->count();

    //     return view('siakad.admin.dataajar.index',compact('pages','jmldata','datakelas','request','tipepelajaran','jurusan','datapelajaran','dataguru'));
    //     // return view('admin.beranda');
    // }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'pelajaran_nama'=>'required',
            'pelajaran_tipepelajaran'=>'required',
            'pelajaran_jurusan'=>'required',
            // 'pelajaran_kelas_nama'=>'required',
            'kelas_nama'=>'required',
            'guru_nomerinduk'=>'required',
            // 'guru_nama'=>'required',
            // 'kkm' => 'required|min:1|max:100',

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);


    $dataguru=DB::table('guru')
    ->where('nomerinduk', '=', $request->guru_nomerinduk)
    ->first();
    // dd($dataajar);
    $guru_nama=$dataguru->nama;

    $cekdatajar=DB::table('dataajar')
    ->where('pelajaran_nama', '=', $request->pelajaran_nama)
    ->where('kelas_nama', '=', $request->kelas_nama)
    ->count();
    if($cekdatajar>0){

        dataajar::where('pelajaran_nama',$request->pelajaran_nama)
        ->where('kelas_nama', '=', $request->kelas_nama)
            ->update([
                'guru_nomerinduk'=>$request->guru_nomerinduk,
                'guru_nama'     =>   $guru_nama,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
    }else{

       DB::table('dataajar')->insert(
        array(
               'pelajaran_nama'     =>   $request->pelajaran_nama,
               'pelajaran_tipepelajaran'     =>   $request->pelajaran_tipepelajaran,
               'pelajaran_jurusan'     =>   $request->pelajaran_jurusan,
               'kelas_nama'     =>   $request->kelas_nama,
               'guru_nomerinduk'     =>   $request->guru_nomerinduk,
               'guru_nama'     =>   $guru_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
    }

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    public function store_ajax(Request $request)
    {
        // dd($request);
        $request->validate([
            'pelajaran_nama'=>'required',
            'pelajaran_tipepelajaran'=>'required',
            'pelajaran_jurusan'=>'required',
            // 'pelajaran_kelas_nama'=>'required',
            'kelas_nama'=>'required',
            'guru_nomerinduk'=>'required',
            // 'guru_nama'=>'required',
            // 'kkm' => 'required|min:1|max:100',

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);


        $dataguru=DB::table('guru')
        ->where('nomerinduk', '=', $request->guru_nomerinduk)
        ->first();
        // dd($dataajar);
        $guru_nama=$dataguru->nama;

        $cekdatajar=DB::table('dataajar')
        ->where('pelajaran_nama', '=', $request->pelajaran_nama)
        ->where('kelas_nama', '=', $request->kelas_nama)
        ->count();

                if($cekdatajar>0){

                    dataajar::where('pelajaran_nama',$request->pelajaran_nama)
                    ->where('kelas_nama', '=', $request->kelas_nama)
                        ->update([
                            'guru_nomerinduk'=>$request->guru_nomerinduk,
                            'guru_nama'     =>   $guru_nama,
                            'updated_at'=>date("Y-m-d H:i:s")
                        ]);
                }else{

                        DB::table('dataajar')->insert(
                            array(
                                'pelajaran_nama'     =>   $request->pelajaran_nama,
                                'pelajaran_tipepelajaran'     =>   $request->pelajaran_tipepelajaran,
                                'pelajaran_jurusan'     =>   $request->pelajaran_jurusan,
                                'kelas_nama'     =>   $request->kelas_nama,
                                'guru_nomerinduk'     =>   $request->guru_nomerinduk,
                                'guru_nama'     =>   $guru_nama,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s")
                            ));
                }



                $dataajar_id=0;
                // ambildataajar
                $cekdataajar=DB::table('dataajar')
                ->where('pelajaran_nama', '=', $request->pelajaran_nama)
                ->where('kelas_nama', '=', $request->kelas_nama)
                ->count();

                if ($cekdataajar>0){

                $ambildataajar=DB::table('dataajar')
                ->where('pelajaran_nama', '=', $request->pelajaran_nama)
                ->where('kelas_nama', '=', $request->kelas_nama)
                ->first();

                $dataajar_id=$ambildataajar->id;
                }


                return response()->json(
                    [
                        'success' => true,
                        // 'message' => 'Data inserted successfully'
                        'message' => $dataajar_id
                    ]
                );
    }

    public function store_ajax_new(Request $request)
    {
        // dd($request);
        $request->validate([
            'id'=>'required',
            'guru_nomerinduk'=>'required',

        ],
        [
            'guru_nomerinduk.required'=>'Nama Harus diisi',

        ]);


        $dataguru=DB::table('guru')
        ->where('nomerinduk', '=', $request->guru_nomerinduk)
        ->first();
        // dd($dataajar);
        $guru_nama=$dataguru->nama;

        $cekdatajar=DB::table('dataajar')
        ->where('id', '=', $request->id)
        ->count();

                if($cekdatajar>0){

                    dataajar::where('id',$request->id)
                        ->update([
                            'guru_nomerinduk'=>$request->guru_nomerinduk,
                            'guru_nama'     =>   $guru_nama,
                            'updated_at'=>date("Y-m-d H:i:s")
                        ]);
                }else{
                        $ambildata=DB::table('dataajar')->where('id',$request->id)->first();
                        DB::table('dataajar')->insert(
                            array(
                                'pelajaran_nama'     =>   $ambildata->pelajaran_nama,
                                'pelajaran_tipepelajaran'     =>   $ambildata->pelajaran_tipepelajaran,
                                'pelajaran_jurusan'     =>   $ambildata->pelajaran_jurusan,
                                'kelas_nama'     =>   $ambildata->kelas_nama,
                                'guru_nomerinduk'     =>   $request->guru_nomerinduk,
                                'guru_nama'     =>   $guru_nama,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s")
                            ));
                }



                // $dataajar_id=0;
                // // ambildataajar
                // $cekdataajar=DB::table('dataajar')
                // ->where('id', '=', $request->id)
                // ->count();

                // if ($cekdataajar>0){

                // $ambildataajar=DB::table('dataajar')
                // ->where('id', '=', $request->id)
                // ->first();

                // $dataajar_id=$ambildataajar->id;
                // }


                return response()->json(
                    [
                        'success' => true,
                        // 'message' => 'Data inserted successfully'
                        'message' => $request->id
                    ]
                );
    }

    public function proses_update($request,$dataajar)
    {

        $request->validate([
            'guru_nomerinduk'=>'required'
        ],
        [
            'guru_nomerinduk.required'=>'Guru harus diisi'


        ]);



        dataajar::where('id',$dataajar->id)
            ->update([
                'guru_nomerinduk'=>$request->guru_nomerinduk,
                'guru_nama'     =>   $request->guru_nama,
            ]);
    }

    public function siakad_update(Request $request, dataajar $dataajar)
    {
        $this->proses_update($request,$dataajar);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        dataajar::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');

    }
}
