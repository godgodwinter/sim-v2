<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminsiswacontroller extends Controller
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
        $pages='siswa';
        $datas=siswa::with('users')->with('kelas')
        ->paginate(Fungsi::paginationjml());
        $kelas=kelas::get();
        // dd($datas);

        return view('pages.admin.siswa.index',compact('datas','request','pages','kelas'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='siswa';
        $datas=siswa::with('users')
        ->where('nama','like',"%".$cari."%")
        ->orWhere('nomerinduk','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        $kelas=kelas::get();
        return view('pages.admin.siswa.index',compact('datas','request','pages','kelas'));
    }

    public function reset(siswa $id)
    {
        // dd($siswa);

        User::where('nomerinduk',$id->nis)
        ->update([
            'password' => Hash::make(Fungsi::passdefaultsiswa()),
        'updated_at'=>date("Y-m-d H:i:s")
        ]);

        return redirect()->back()->with('status','Reset berhasil! Password baru : '.Fungsi::passdefaultsiswa().'')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function create()
    {
        $pages='siswa';

        $tapel=DB::table('tapel')->get();

        $kelas=DB::table('kelas')->get();

        return view('pages.admin.siswa.create',compact('pages','tapel','kelas'));
    }

    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'nomerinduk' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'nama'=>'required',
            'alamat'=>'required',
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
            'nomerinduk.unique'=>'nomerinduk sudah digunakan',
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);


        //insert users
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $request->nomerinduk,
               'name'     =>   $request->nama,
               'username'     =>   date('YmdHis'),
               'password' => Hash::make($request->password),
               'tipeuser'     =>   'siswa',
               'email'     =>   $request->email,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        $users=DB::table('users')->orderBy('id','desc')->first();
        $namafilebaru=$request->nomerinduk.'_'.$request->nama;
        $file = $request->file('siswafoto');
        $tujuan_upload = 'storage/siswa';
        $photoku="";
        if($file!=null){
            // upload file
            $file->move($tujuan_upload,"siswa/".$namafilebaru.".jpg");
            $photoku="siswa/".$namafilebaru.".jpg";
        }
        $users_id=$users->id;
            DB::table('siswa')->insert(
                array(
                        'nomerinduk'     =>   $request->nomerinduk,
                        'nama'     =>   $request->nama,
                        'agama'     =>   $request->agama,
                        'tempatlahir'     =>   $request->tempatlahir,
                        'tgllahir'     =>   $request->tgllahir,
                        'alamat'     =>   $request->alamat,
                        'jk'     =>   $request->jk,
                        'kelas_id'     =>   $request->kelas_id,
                        'tapel_id'     =>   $request->tapel_id,
                        'siswafoto' =>   $photoku,
                        'moodleuser'     =>   $request->moodleuser,
                        'moodlepass'     =>   $request->moodlepass,
                        'users_id'     =>   $users_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



    return redirect()->route('siswa')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(siswa $id)
    {
        $pages='siswa';


            $u=DB::table('users')->where('id',$id->users_id)->get();


        $tapel=DB::table('tapel')->get();
        $kelas=DB::table('kelas')->get();

        $t1=DB::table('tapel')->where('id',$id->tapel_id)->get();
        $k1=DB::table('kelas')->where('id',$id->kelas_id)->get();

        return view('pages.admin.siswa.edit',compact('pages','id','tapel','kelas','t1','k1','u'));
    }
    public function update(siswa $id,Request $request)
    {


        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required",
            ],
            [
            ]);
        }

        $request->validate([
            'nama'=>'required',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);


        $files = $request->file('sekolah_logo');

        $imagesDir=public_path().'/storage';

        if($files!=null){

            if (file_exists( public_path().'/storage'.'/'.$id->siswafoto)AND($id->siswafoto!=null)){
                chmod($imagesDir, 0777);
                $image_path = public_path().'/storage'.'/'.$id->siswafoto;
                unlink($image_path);
            }
            // dd('storage'.'/'.$id->sekolah_logo);
            $namafilebaru=$request->nomerinduk.'_'.$request->nama;
            $file = $request->file('siswafoto');
            $tujuan_upload = 'storage/siswa';
                    // upload file
            $file->move($tujuan_upload,"siswa/".$namafilebaru.".jpg");
            siswa::where('id',$id->id)
            ->update([
                'siswafoto' => "siswa/".$namafilebaru.".jpg",
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }

        if($request->password!=null OR $request->password!=''){

        $request->validate([
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8'
        ],
        [
        ]);
            siswa::where('id',$id->id)
            ->update([
                'nomerinduk'     =>   $request->nomerinduk,
                        'nama'     =>   $request->nama,
                        'agama'     =>   $request->agama,
                        'tempatlahir'     =>   $request->tempatlahir,
                        'tgllahir'     =>   $request->tgllahir,
                        'alamat'     =>   $request->alamat,
                        'jk'     =>   $request->jk,
                        'kelas_id'     =>   $request->kelas_id,
                        'tapel_id'     =>   $request->tapel_id,

                        'moodleuser'     =>   $request->moodleuser,
                        'moodlepass'     =>   $request->moodlepass,
                       'updated_at'=>date("Y-m-d H:i:s")
            ]);
            user::where('id',$id->users_id)
            ->update([
                'nomerinduk'     =>   $request->nomerinduk,
                'name'     =>   $request->nama,
                //'username'     =>   date('YmdHis'),
                'password' => Hash::make($request->password),
                'email'     =>   $request->email,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            siswa::where('id',$id->id)
            ->update([
                'nomerinduk'     =>   $request->nomerinduk,
                        'nama'     =>   $request->nama,
                        'agama'     =>   $request->agama,
                        'tempatlahir'     =>   $request->tempatlahir,
                        'tgllahir'     =>   $request->tgllahir,
                        'alamat'     =>   $request->alamat,
                        'jk'     =>   $request->jk,
                        'kelas_id'     =>   $request->kelas_id,
                        'tapel_id'     =>   $request->tapel_id,

                        'moodleuser'     =>   $request->moodleuser,
                        'moodlepass'     =>   $request->moodlepass,
                       'updated_at'=>date("Y-m-d H:i:s")
            ]);
            user::where('id',$id->users_id)
            ->update([
                'nomerinduk'     =>   $request->nomerinduk,
                'name'     =>   $request->nama,

                'email'     =>   $request->email,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }


    return redirect()->route('siswa')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(siswa $id){

        siswa::destroy($id->id);
        return redirect()->route('siswa')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        siswa::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='siswa';
        $datas=siswa::with('users')
        ->paginate(Fungsi::paginationjml());
        return view('pages.admin.siswa.index',compact('datas','request','pages'));

    }
}
