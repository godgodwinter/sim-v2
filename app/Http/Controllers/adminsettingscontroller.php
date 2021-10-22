<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\settings;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class adminsettingscontroller extends Controller
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
    public function index(){
        $pages='settings';
        $datas=DB::table('settings')->where('id',1)->first();
        return view('pages.admin.settings.index',compact('datas','pages'));
    }
    public function update(settings $id,Request $request){
        // dd($request,$id);
        settings::where('id',$id->id)
        ->update([
            'app_nama' => $request->app_nama,
            'app_namapendek' => $request->app_namapendek,
            'paginationjml' => $request->paginationjml,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
        return redirect()->route('settings')->with('status','Data berhasil diubah!')->with('tipe','success');
    }

    public function resetpassword(Request $request)
    {
        #WAJIB
        $pages='settings';
        $datas=siswa::with('users')
        ->paginate(Fungsi::paginationjml());
        return view('pages.admin.settings.resetpassword',compact('datas','request','pages'));
    }
    public function passwordujian(Request $request)
    {
        #WAJIB
        $pages='settings';
        return view('pages.admin.settings.passwordujian',compact('pages','request'));
    }
    public function resetpasswordcari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='siswa';
        $datas=siswa::with('users')
        ->where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.settings.resetpassword',compact('datas','request','pages'));
    }

    public function resetsemua(Request $request)
    {
        $datas=DB::table('siswa')->get();
            foreach($datas as $siswa)
            {
                User::where('nomerinduk',$siswa->nomerinduk)
                ->update([
                    'password' => Hash::make(Fungsi::passdefaultsiswa()),
                   'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }
            return redirect()->back()->with('status','Data berhasil direset!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function passwordujiangenerate(Request $request){
        dd($request);
        $jml=6;
        if(($request->jml!=null)AND($request->jml!='')){
            $jml=$request->jml;
        }
        $moodleuser='a';
        $moodlepass='b';
        // dd($jml);
        // 1. ambil semua data siswa
        $siswas=DB::table('siswa')
            ->get();
        foreach($siswas as $siswa){

            $faker = Faker::create('id_ID');

            $moodleuser=$faker->unique()->regexify('[A-Za-z0-9]{'.$jml.'}');
            $moodlepass=$faker->unique()->regexify('[A-Za-z0-9]{'.$jml.'}');
            // dd($moodleuser,$moodlepass,$jml);

        siswa::where('id',$siswa->id)
        ->update([
            'moodleuser'     =>   $moodleuser,
            'moodlepass'     =>   $moodlepass,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
        }
        // 2. faker generate username dan password
        // 3. update data
        return redirect()->back()->with('status','Generate Berhasil !')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
