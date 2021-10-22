<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminsilabuscontroller extends Controller
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
        $pages='mapel';
        $datas=dataajar::paginate(Fungsi::paginationjml());

        return view('pages.admin.silabus.index',compact('datas','request','pages'));
    }
}
