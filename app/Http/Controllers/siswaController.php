<?php

namespace App\Http\Controllers;

use App\Exports\ExportSiswa;
use App\Imports\ImportSiswa;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\tagihansiswa;
use App\Models\tagihansiswadetail;
use App\Models\tapel;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class siswaController extends Controller
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
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('siswa')
        ->paginate($this->paginationjml());
    
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        return view('admin.siswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
        // return view('admin.beranda');
    }

    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;

        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('siswa')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->orWhere('nis','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();


        return view('admin.siswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
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
            'moodleuser'=>'required',
            'moodlepass'=>'required',
            'tempatlahir'=>'required',
            'tgllahir'=>'required',
            'agama'=>'required',
            'alamat'=>'required',
            'tapel_nama'=>'required',
            'kelas_nama'=>'required',
            'jk'=>'required',
            'nis' => 'required|unique:siswa',
            'email' => 'required|email|unique:users',
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
            'nis.unique'=>'NIS sudah digunakan',
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        //inser siswa
       DB::table('siswa')->insert(
        array(
               'nis'     =>   $request->nis,
               'nama'     =>   $request->nama,
               'tempatlahir'     =>   $request->tempatlahir,
               'tgllahir'     =>   $request->tgllahir,
               'agama'     =>   $request->agama,
               'alamat'     =>   $request->alamat,
               'tapel_nama'     =>   $request->tapel_nama,
               'kelas_nama'     =>   $request->kelas_nama,
               'jk'     =>   $request->jk,
               'moodleuser'     =>   $request->moodleuser,
               'moodlepass'     =>   $request->moodlepass,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        //insert users
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $request->nis,
               'name'     =>   $request->nama,
               'password' => Hash::make($request->password),
               'tipeuser'     =>   'siswa',
               'email'     =>   $request->email,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        
        return redirect(URL::to('/').'/admin/datatagihan/addall')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,siswa $siswa)
    {
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=siswa::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();
        $datausers = DB::table('users')->where('nomerinduk',$siswa->nis)->get();

        return view('admin.siswa.edit',compact('pages','jmldata','datas','tapel','kelas','siswa','datausers','request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, siswa $siswa)
    { 
        // dd($siswa->nis);
        $datausers = DB::table('users')->where('nomerinduk',$siswa->nis)->get();
        foreach($datausers as $d){
            $emailku=$d->id;
        }
        // dd($emailku);

        $request->validate([
            'nama'=>'required',
            'tempatlahir'=>'required',
            'tgllahir'=>'required',
            'agama'=>'required',
            'alamat'=>'required',
            'jk'=>'required',
            'tapel_nama'=>'required',
            'kelas_nama'=>'required',
            'nis' => 'required|unique:siswa,nis,'.$siswa->id,
            'email' => 'unique:users,email,'.$emailku,
            'moodleuser'=>'required',
            'moodlepass'=>'required',
        ],
        [
            'nis.unique'=>'NIS sudah digunakan',
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
        
        $nominaltagihan=$this->nominaltagihandefault();
        $datatagihanatur = DB::table('tagihanatur')
            ->where('tapel_nama',$request->tapel_nama)
            ->where('kelas_nama',$request->kelas_nama)
        ->get();
        foreach($datatagihanatur as $dttagihanatur){
            $nominaltagihan=$dttagihanatur->nominaltagihan;
        }

        

        tagihansiswa::where('siswa_nis',$siswa->nis)
        ->update([
            'kelas_nama'     =>   $request->kelas_nama,
            'nominaltagihan'     =>   $nominaltagihan,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        tagihansiswadetail::where('siswa_nis',$siswa->nis)
        ->update([
            'kelas_nama'     =>   $request->kelas_nama,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
        
         //aksi update

        siswa::where('id',$siswa->id)
            ->update([
               'nis'     =>   $request->nis,
               'nama'     =>   $request->nama,
               'tempatlahir'     =>   $request->tempatlahir,
               'tgllahir'     =>   $request->tgllahir,
               'agama'     =>   $request->agama,
               'alamat'     =>   $request->alamat,
               'jk'     =>   $request->jk,
               'moodleuser'     =>   $request->moodleuser,
               'moodlepass'     =>   $request->moodlepass,
               'tapel_nama'     =>   $request->tapel_nama,
               'kelas_nama'     =>   $request->kelas_nama,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);


        User::where('nomerinduk',$siswa->nis)
        ->update([
            'name'     =>   $request->nama,
           'nomerinduk'     =>   $request->nis,
           'email'     =>   $request->email,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        if(!empty($request->password)){

                    User::where('nomerinduk',$siswa->nis)
                    ->update([
                        'password' => Hash::make($request->password),
                    'updated_at'=>date("Y-m-d H:i:s")
                    ]);

        }
            //jika ganti tapel dan kelas ganti pembayaran (belum)
        return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(siswa $siswa)
    {

        DB::table('tagihansiswa')->where('siswa_nis', $siswa->nis)->where('tapel_nama',$this->tapelaktif())->delete();
        // tagihansiswa::whereIn('siswa_nis',$siswa->id)->where('tapel_nama',$this->tapelaktif())->delete();

        DB::table('users')->where('nomerinduk', $siswa->nis)->delete();
        siswa::destroy($siswa->id);

       
        return redirect(URL::to('/').'/admin/siswa')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
  
    }

    public function resetpass(siswa $siswa)
    {
        // dd($siswa);

        User::where('nomerinduk',$siswa->nis)
        ->update([
            'password' => Hash::make($this->passdefaultsiswa()),
        'updated_at'=>date("Y-m-d H:i:s")
        ]);
  
        return redirect()->back()->with('status','Reset berhasil! Password baru : '.$this->passdefaultsiswa().'')->with('tipe','success')->with('icon','fas fa-edit');
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
        tagihansiswa::whereIn('siswa_nis',$ids)->where('tapel_nama',$this->tapelaktif())->delete();

        User::whereIn('nomerinduk',$ids)->delete();

        siswa::whereIn('nis',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('siswa')
        ->paginate($this->paginationjml());
    
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        return view('admin.siswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));

    }
}
