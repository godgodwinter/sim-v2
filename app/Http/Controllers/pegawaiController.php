<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class pegawaiController extends Controller
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
        $pages='pegawai';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pegawai')
        ->paginate($this->paginationjml());
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pegawai')->get();
        $jmldata = DB::table('pegawai')->count();

        return view('admin.pegawai.index',compact('pages','jmldata','datas','kategori','request'));
        // return view('admin.beranda');
    }
    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $kategori_nama=$request->kategori_nama;

        #WAJIB
        $pages='pegawai';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('pegawai')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->where('kategori_nama','like',"%".$kategori_nama."%")
    ->orWhere('nig','like',"%".$cari."%")
    ->where('kategori_nama','like',"%".$kategori_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pegawai')->get();
        $jmldata = DB::table('pegawai')->count();


        return view('admin.pegawai.index',compact('pages','jmldata','datas','kategori','request'));
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
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            'kategori_nama'=>'required',
            'nig' => 'required|unique:pegawai',
            'email' => 'required|email|unique:users',
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
            'nig.unique'=>'nig sudah digunakan',
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        if($request->kategori_nama==='Kepala Sekolah'){
            $tipeuser='kepsek';
        }else if($request->kategori_nama==='Administrator/Bendahara'){
            $tipeuser='admin';

        }else{
            $tipeuser='other';
        }
        //inser pegawai
       DB::table('pegawai')->insert(
        array(
               'nig'     =>   $request->nig,
               'nama'     =>   $request->nama,
               'alamat'     =>   $request->alamat,
               'telp'     =>   $request->telp,
               'kategori_nama'     =>   $request->kategori_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        //insert users
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $request->nig,
               'name'     =>   $request->nama,
               'password' => Hash::make($request->password),
               'tipeuser'     =>   $tipeuser,
               'email'     =>   $request->email,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,pegawai $pegawai)
    {
        // dd($pegawai);
        #WAJIB
        $pages='pegawai';
        $jmldata='0';
        $datas='0';


        $datas=pegawai::all();
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pegawai')->get();
        $jmldata = DB::table('pegawai')->count();
        $datausers = DB::table('users')->where('nomerinduk',$pegawai->nig)->get();

        return view('admin.pegawai.edit',compact('pages','jmldata','datas','kategori','pegawai','datausers','request'));
        // return view('admin.beranda');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pegawai $pegawai)
    {

        // dd($siswa->nis);
        $datausers = DB::table('users')->where('nomerinduk',$pegawai->nig)->get();
        foreach($datausers as $d){
            $emailku=$d->id;
        }
        // dd($emailku);

        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            'kategori_nama'=>'required',
            'nig' => 'required|unique:pegawai,nig,'.$pegawai->id,
            'email' => 'unique:users,email,'.$emailku,
        ],
        [
            'nig.unique'=>'Nomer Induk sudah digunakan',
            // 'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        if(!empty($request->password)){

        $request->validate([
           
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
           
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        }
         //aksi update

        pegawai::where('id',$pegawai->id)
            ->update([
                'nig'     =>   $request->nig,
                'nama'     =>   $request->nama,
                'alamat'     =>   $request->alamat,
                'telp'     =>   $request->telp,
                'kategori_nama'     =>   $request->kategori_nama,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);


        User::where('nomerinduk',$pegawai->nig)
        ->update([
            'name'     =>   $request->nama,
           'nomerinduk'     =>   $request->nig,
           'email'     =>   $request->email,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        if(!empty($request->password)){

                // dd($request->password);
                    User::where('nomerinduk',$pegawai->nig)
                    ->update([
                        'password' => Hash::make($request->password),
                    'updated_at'=>date("Y-m-d H:i:s")
                    ]);

        }

        return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(pegawai $pegawai)
    {
        pegawai::destroy($pegawai->id);
       
        DB::table('users')->where('nomerinduk', $pegawai->nig)->delete();
        return redirect(URL::to('/').'/admin/pegawai')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
  
    }

    public function resetpass(pegawai $pegawai)
    {
        // dd($siswa);

        User::where('nomerinduk',$pegawai->nig)
        ->update([
            'password' => Hash::make($this->passdefaultpegawai()),
        'updated_at'=>date("Y-m-d H:i:s")
        ]);
  
        return redirect()->back()->with('status','Reset berhasil! Password baru : '.$this->passdefaultpegawai().'')->with('tipe','success')->with('icon','fas fa-edit');
    }
}
