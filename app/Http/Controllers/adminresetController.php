<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\pemasukan;
use App\Models\pengeluaran;
use App\Models\settings;
use App\Models\siswa;
use App\Models\tagihanatur;
use App\Models\tagihansiswa;
use App\Models\tagihansiswadetail;
use App\Models\tapel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminresetController extends Controller
{
    public function hard(){
        // dd('hard');
        tapel::truncate();
        tagihansiswadetail::truncate();
        siswa::truncate();
        kelas::truncate();
        tagihanatur::truncate();
        pemasukan::truncate();
        pengeluaran::truncate();

        User::where('tipeuser','siswa')
        // ->whereNotIn('id', $keep)
        ->delete();

        tagihansiswa::truncate();
        tagihansiswadetail::truncate();

        settings::where('id','1')
        ->update([
            'tapelaktif'     => '2021/2022',
        ]);

        DB::table('tapel')->insert(
            array(
                    'nama' =>'2021/2022',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
            ));
            
        return redirect()->back()->with('status','Proses Reset berhasil! !')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function settings(){
        // dd('reset settings');

        settings::where('id','1')
        ->update([
            // 'tapelaktif'     => '2021/2022',
            'paginationjml' => '10',
            'tapelaktif' => '2021/2022',
            'sekolahnama' => 'SMP ABCD 01 Malang',
            'sekolahalamat' => 'Jl. Abcd Desa Qwerty Kecamatan Zxcvb',
            'sekolahtelp' => '0341-123456',
            'aplikasijudul' => 'SIM SMK KROMENGAN',
            'aplikasijudulsingkat' => 'SIM',
            'nominaltagihandefault' => '1000000',
            'passdefaultsiswa' => 'siswa123',
            'passdefaultpegawai' => '12345678',
            'passdefaultortu' => 'ortu123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return redirect()->back()->with('status','Proses Reset berhasil! !')->with('tipe','success')->with('icon','fas fa-edit');

    }
    public function tagihansiswa(){
        // dd('tagihansiswa');
        tagihansiswadetail::truncate();
        return redirect()->back()->with('status','Proses Reset berhasil! !')->with('tipe','success')->with('icon','fas fa-edit');

    }
    public function siswa(){
        siswa::truncate();

        User::where('tipeuser','siswa')
        // ->whereNotIn('id', $keep)
        ->delete();

        tagihansiswa::truncate();
        tagihansiswadetail::truncate();
            
        return redirect()->back()->with('status','Proses Reset berhasil! !')->with('tipe','success')->with('icon','fas fa-edit');
    }
}
