<?php

namespace App\Http\Controllers;

use App\Exports\exportkd;
use App\Exports\exportmateri;
use App\Helpers\Fungsi;
use App\Imports\importkd;
use App\Imports\importmateri;
use App\Models\dataajar;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class adminmateripokokcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='guru'){
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
    public function edit(dataajar $dataajar,kompetensidasar $kd,materipokok $id, Request $request)
    {
        #WAJIB
        $pages='banksoal';
        return view('pages.admin.materipokok.edit',compact('request','pages','kd','dataajar','id'));
    }
    public function update(dataajar $dataajar,kompetensidasar $kd,materipokok $id,Request $request)
    {

        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required",
            ],
            [
            ]);
        }

        $namafilebaru=date('YmdHis');
        $file = $request->file('link');
        if($file!=null){
            $tujuan_upload = 'materi';
                    // upload file
            $file->move($tujuan_upload,"materi/".$namafilebaru.'.'.$file->getClientOriginalExtension());
            $namafileku="materi/".$namafilebaru.'.'.$file->getClientOriginalExtension();

            materipokok::where('id',$id->id)
            ->update([
                'link'     =>   $namafileku,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }

        materipokok::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('dataajar.kompetensidasar.materipokok.index',[$dataajar->id,$kd->id])->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(dataajar $dataajar,kompetensidasar $kd,materipokok $id){

        materipokok::destroy($id->id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }
    public function multidel(dataajar $dataajar,kompetensidasar $kd,Request $request)
    {

        $ids=$request->ids;
        materipokok::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='banksoal';
        $datas=materipokok::with('kompetensidasar')
        ->where('kompetensidasar_id',$kd->id)
        ->orderBy('id','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.admin.materipokok.index',compact('datas','request','pages','kd','dataajar'));

    }
    public function exportmateri(kompetensidasar $kd,Request $request){
        // $databanksoal=banksoal::where('dataajar_id',$dataajar->id)->get();
        // dd($databanksoal,$dataajar,'Export');
        $tgl=date("YmdHis");
		return Excel::download(new exportmateri($kd), 'sim-materi-'.$kd->id.'-'.$tgl.'.xlsx');
    }
    public function importmateri(kompetensidasar $kd,Request $request){
        // dd('import');
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

		$file = $request->file('file');

		$nama_file = rand().$file->getClientOriginalName();

		$file->move('file_temp',$nama_file);

		Excel::import(new importmateri($kd), public_path('/file_temp/'.$nama_file));

        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');

    }
}
