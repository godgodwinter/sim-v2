<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminmateripokokcontroller extends Controller
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
    public function index(dataajar $dataajar,kompetensidasar $kd, Request $request)
    {
        #WAJIB
        $pages='banksoal';
        $datas=materipokok::with('kompetensidasar')
        ->where('kompetensidasar_id',$kd->id)
        ->orderBy('id','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.admin.materipokok.index',compact('datas','request','pages','kd','dataajar'));
    }
    public function create(dataajar $dataajar,kompetensidasar $kd, Request $request)
    {
        #WAJIB
        $pages='banksoal';
        return view('pages.admin.materipokok.create',compact('request','pages','kd','dataajar'));
    }
    public function store(dataajar $dataajar,kompetensidasar $kd, Request $request)
    {
        // dd($request);
        $request->validate([
            'nama'=>'required',
            'link' => 'max:10000|mimes:pdf,png,jpeg,xml,ppt,pptx,doc,docx,xls,xlsx', //10MB
        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);

        $namafilebaru=date('YmdHis');
        $file = $request->file('link');
        if($file!=null){
            $tujuan_upload = 'materi';
                    // upload file
            $file->move($tujuan_upload,"materi/".$namafilebaru.'.'.$file->getClientOriginalExtension());
            $namafileku="materi/".$namafilebaru.'.'.$file->getClientOriginalExtension();

        }else{
            return redirect()->back()->with('status','Gagal, Pilih materi yang akan di uplaod!')->with('tipe','error')->with('icon','fas fa-feather');
        }

        DB::table('materipokok')->insert(
            array(
                   'nama'     =>   $request->nama,
                   'kompetensidasar_id'     =>   $kd->id,
                   'link'     =>   $namafileku,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));
        // dd($namafileku);
        #WAJIB
        return redirect()->route('dataajar.kompetensidasar.materipokok.index',[$dataajar->id,$kd->id])->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
}
