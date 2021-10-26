<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\mapel;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan'));
        }else{

            return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan'));
        }
    }
}
