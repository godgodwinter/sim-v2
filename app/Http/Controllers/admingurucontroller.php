<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class admingurucontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        #WAJIB
        $pages='guru';
        $datas=guru::with('users')
        ->paginate(Fungsi::paginationjml());
        return view('pages.admin.guru.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='guru';
        $datas=guru::with("users")
        ->where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.guru.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='guru';

        return view('pages.admin.guru.create',compact('pages'));
    }

    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'nomerinduk' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
            'nomerinduk.unique'=>'nomerinduk sudah digunakan',
            'email' =>'email sudah digunakan',
            // 'username' =>'username sudah digunakan',
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        //insert users
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $request->nomerinduk,
               'name'     =>   $request->nama,
               'username'     =>   date("Y-m-d H:i:s"),//$request->username,
               'password' => Hash::make($request->password),
               'tipeuser'     =>   'guru',
               'email'     =>   $request->email,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        $users=DB::table('users')->orderBy('id','desc')->first();
        $users_id=$users->id;
            DB::table('guru')->insert(
                array(
                        'nomerinduk'     =>   $request->nomerinduk,
                        'nama'     =>   $request->nama,
                        'alamat'     =>   $request->alamat,
                        'telp'     =>   $request->telp,
                        'users_id'     =>   $users_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



    return redirect()->route('guru')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(guru $id)
    {
        $pages='guru';

        return view('pages.admin.guru.edit',compact('pages','id'));
    }
    public function update(guru $id,Request $request)
    {

        if($request->nomorinduk!=$id->nomorinduk){

            $request->validate([
                'nomerinduk' => 'required|unique:users',
            ],
            [
                'nomerinduk.unique'=>'nomerinduk sudah digunakan',

            ]);
        }
        // dd($request->email,$id->users->email);
        if($request->email!=$id->users->email){

            $request->validate([
                'email' => 'required|email|unique:users',
            ],
            [

            ]);
        }



        if($request->password!=null OR $request->password!=''){

        $request->validate([
            'nama'=>'required',
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);
        guru::where('id',$id->id)
            ->update([
                'nomerinduk'     =>   $request->nomerinduk,
                        'nama'     =>   $request->nama,
                        'alamat'     =>   $request->alamat,
                        'telp'     =>   $request->telp,
                       'updated_at'=>date("Y-m-d H:i:s")
            ]);

            User::where('id',$id->users_id)
            ->update([
                'email'     =>   $request->email,
                'nomerinduk'     =>   $request->nomerinduk,
                'password' => Hash::make($request->password),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
                }else{


        User::where('id',$id->users_id)
        ->update([
            'email'     =>   $request->email,
            'nomerinduk'     =>   $request->nomerinduk,
            'name'     =>   $request->nama,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);




        }


    return redirect()->route('guru')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(guru $id){

        guru::destroy($id->id);
        return redirect()->route('guru')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        guru::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='guru';
        $datas=guru::with('users')
        ->paginate(Fungsi::paginationjml());
        return view('pages.admin.guru.index',compact('datas','request','pages'));

    }
}
