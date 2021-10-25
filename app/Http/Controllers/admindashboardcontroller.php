<?php

namespace App\Http\Controllers;

use App\Models\mapel;
use App\Models\siswa;
use Illuminate\Http\Request;

class admindashboardcontroller extends Controller
{
    public function index(){

        $pages='dashboard';
        $mapel=mapel::get();
        $laki=siswa::where('jk','Laki-laki')->count();
        $perempuan=siswa::where('jk','!=','Laki-laki')->count();
        // dd($laki,$perempuan);
        return view('pages.admin.dashboard.index',compact('pages','mapel','laki','perempuan'));
    }
}
