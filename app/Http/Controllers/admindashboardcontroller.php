<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\mapel;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class admindashboardcontroller extends Controller
{
    public function index(){

        $pages='dashboard';
        $mapel=mapel::get();
        $laki=siswa::where('jk','Laki-laki')->count();
        $perempuan=siswa::where('jk','!=','Laki-laki')->count();
        // dd($laki,$perempuan);
        if((Auth::user()->tipeuser)=='admin'){

            return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan'));
        }elseif((Auth::user()->tipeuser)=='guru'){

            $guru_id=guru::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
            $mapel=mapel::get();
            $laki=siswa::where('jk','Laki-laki')->count();
            $perempuan=siswa::where('jk','!=','Laki-laki')->count();
            return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan','guru_id'));

        }elseif((Auth::user()->tipeuser)=='siswa'){
            $siswa_id=siswa::where('nomerinduk',Auth::user()->nomerinduk)->pluck('id');
            $datasiswa=siswa::with('kelas')->with('users')->where('id',$siswa_id)->first();

            return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan','datasiswa'));
        }else{

            return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan'));
        }
    }

    public function siswaupdate(siswa $id,Request $request)
    {


        if($request->email!==$id->users->email){

            $request->validate([
                'email' => "required|email|unique:users",
            ],
            [
                'email.unique' => 'Email sudah digunakan'
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
                        'agama'     =>   $request->agama,
                        'tempatlahir'     =>   $request->tempatlahir,
                        'tgllahir'     =>   $request->tgllahir,
                        'alamat'     =>   $request->alamat,
                        'jk'     =>   $request->jk,

                       'updated_at'=>date("Y-m-d H:i:s")
            ]);
            user::where('id',$id->users_id)
            ->update([
                //'username'     =>   date('YmdHis'),
                'password' => Hash::make($request->password),
                'email'     =>   $request->email,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            siswa::where('id',$id->id)
            ->update([
                        'agama'     =>   $request->agama,
                        'tempatlahir'     =>   $request->tempatlahir,
                        'tgllahir'     =>   $request->tgllahir,
                        'alamat'     =>   $request->alamat,
                        'jk'     =>   $request->jk,

                       'updated_at'=>date("Y-m-d H:i:s")
            ]);
            User::where('id',$id->users_id)
            ->update([
                'email'     =>   $request->email,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }


    return redirect()->back()->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
}
