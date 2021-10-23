<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\banksoal;
use App\Models\dataajar;
use App\Models\mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminbanksoalcontroller extends Controller
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
    public function index(dataajar $dataajar, Request $request)
    {
        // dd($dataajar);
        #WAJIB
        $pages='banksoal';
        $datas=banksoal::with('dataajar')
        ->where('dataajar_id',$dataajar->id)
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.banksoal.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='banksoal';

        return view('pages.admin.banksoal.create',compact('request','pages','dataajar'));
    }
}
