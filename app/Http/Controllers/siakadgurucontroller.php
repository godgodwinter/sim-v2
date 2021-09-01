<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\User;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class siakadgurucontroller extends Controller
{
    public function siakad_index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siakadguru';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('guru')
        ->paginate($this->paginationjml());
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','guru')->get();
        $jmldata = DB::table('guru')->count();

        return view('siakad.admin.guru.index',compact('pages','jmldata','datas','kategori','request'));
        // return view('admin.beranda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            // 'kategori_nama'=>'required',
            'nomerinduk' => 'required|unique:guru,nomerinduk|unique:pegawai,nig|unique:siswa,nis',
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

        $tipeuser='guru';
        //inser pegawai
       DB::table('guru')->insert(
        array(
               'nomerinduk'     =>   $request->nomerinduk,
               'nama'     =>   $request->nama,
               'alamat'     =>   $request->alamat,
               'telp'     =>   $request->telp,
            //    'kategori_nama'     =>   $request->kategori_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        //insert users
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $request->nomerinduk,
               'name'     =>   $request->nama,
               'password' => Hash::make($request->password),
               'tipeuser'     =>   $tipeuser,
               'email'     =>   $request->email,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    public function siakad_show(Request $request,guru $guru)
    {
        // dd($pegawai);
        #WAJIB
        $pages='siakadguru';
        $jmldata='0';
        $datas='0';


        $datas=guru::all();
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','guru')->get();
        $jmldata = DB::table('pegawai')->count();
        $datausers = DB::table('users')->where('nomerinduk',$guru->nomerinduk)->get();

        return view('siakad.admin.guru.edit',compact('pages','jmldata','datas','kategori','guru','datausers','request'));
        // return view('admin.beranda');
    }


    public function rules($nomerinduk)
    {
        return [
            'nomerinduk' => [
                'required',
                Rule::unique('users', 'nomerinduk')->ignore($nomerinduk)
                // Rule::unique('siswa', 'nis')->ignore($nomerinduk),
                // Rule::unique('pegawai', 'nig')->ignore($nomerinduk),
            ]
        ]; 
    }

    public function siakad_update(Request $request, guru $guru)
    {

        // dd($siswa->nis);
        $datausers = DB::table('users')->where('nomerinduk',$guru->nomerinduk)->get();
        foreach($datausers as $d){
            $emailku=$d->id;
        }
        // dd($guru->id);
        // $this->rules($guru->nomerinduk);
        if($request->nomerinduk!==$guru->nomerinduk){

            $request->validate([
                'nomerinduk' => "required|unique:users,nomerinduk,".$request->nomerinduk,
            ],
            [
                'nomerinduk.unique'=>'Nomer Induk sudah digunakan',
                // 'password.same'=>'Password dan Konfirmasi Password berbeda',
    
            ]);
        }
        
        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            // 'kategori_nama'=>'required',
	        // 'nomerinduk' => "required|unique:users,nomerinduk,".$request->nomerinduk,
            // 'nomerinduk' => 'required|unique:guru'. ($guru->nomerinduk ? ",nomerinduk,$guru->nomerinduk" : ''),
            'email' => 'unique:users,email,'.$emailku,
        ],
        [
            'telp.required'=>'Telp Wajib diisi',
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

        guru::where('id',$guru->id)
            ->update([
                'nomerinduk'     =>   $request->nomerinduk,
                'nama'     =>   $request->nama,
                'alamat'     =>   $request->alamat,
                'telp'     =>   $request->telp,
                // 'kategori_nama'     =>   $request->kategori_nama,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);


        User::where('nomerinduk',$guru->nomerinduk)
        ->update([
            'name'     =>   $request->nama,
           'nomerinduk'     =>   $request->nomerinduk,
           'email'     =>   $request->email,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        if(!empty($request->password)){

                // dd($request->password);
                    User::where('nomerinduk',$guru->nomerinduk)
                    ->update([
                        'password' => Hash::make($request->password),
                    'updated_at'=>date("Y-m-d H:i:s")
                    ]);

        }

        return redirect(URL::to('/').'/admin/siakadguru')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

}
