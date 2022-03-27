<?php

namespace App\Http\Controllers;

use App\Exports\exportbanksoal;
use App\Helpers\Fungsi;
use App\Imports\importbanksoal;
use App\Imports\importbanksoalv2;
use App\Models\banksoal;
use App\Models\banksoaljawaban;
use App\Models\dataajar;
use App\Models\generatebanksoal;
use App\Models\generatebanksoal_detail;
use App\Models\generatebanksoal_jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class admingeneratebanksoalcontroller extends Controller
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
    $pages='silabus';
    $datas=generatebanksoal::with('dataajar')
    ->where('dataajar_id',$dataajar->id)
    ->paginate(Fungsi::paginationjml());
// dd($datas);
    return view('pages.admin.generatebanksoal.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='silabus';

        return view('pages.admin.generatebanksoal.create',compact('request','pages','dataajar'));
    }

    public function store(dataajar $dataajar,Request $request){

        // dd('tes');
        $periksajmlsoal=banksoal::where('dataajar_id',$dataajar->id)->count();
        if($periksajmlsoal<$request->jml){
            $jmlsoal=$periksajmlsoal;
        }else{
            $jmlsoal=$request->jml;
        }


        $soalacak=$request->soal;
        $jawabanacak=$request->jawaban;
        // $nomer=4;
        //     dd(Fungsi::periksaabc($nomer));
        $generatebanksoal_id=generatebanksoal::insertGetId(
            array(
                   'jml'     =>   $jmlsoal,
                   'soal'     =>   $request->soal,
                   'jawaban'     =>   $request->jawaban,
                   'tgl'     =>   $request->tgl,
                   'dataajar_id'     =>   $dataajar->id,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));

            // dd($generatebanksoal_id);

        // if jika soal acak
        if($soalacak=='Tidak'){
            $ambilsoal=banksoal::skip(0)->take($request->jml)->get();

        }else{
            $ambilsoal=banksoal::skip(0)->take($request->jml)->inRandomOrder()->get();

        }


        foreach($ambilsoal as $soal){
            // insert soal ketable generatedetail
        $generatebanksoal_detail_id=generatebanksoal_detail::insertGetId(
        array(
               'banksoal_id'     =>   $soal->id,
               'generatebanksoal_id'     =>   $generatebanksoal_id,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));


            // if jika jawaban acak
            if($jawabanacak=='Tidak'){
                $ambiljawaban=banksoaljawaban::where('banksoal_id',$soal->id)->get();

            }else{
                $ambiljawaban=banksoaljawaban::where('banksoal_id',$soal->id)->inRandomOrder()->get();

            }
            $nomer=0;
        foreach($ambiljawaban as $jawaban){
            // insert soal ketable generatejawaban masukkan fungsi periksaabc ke field pilihan dan benarsalah
            $nomer++;
            if($jawaban->nilai>0){
                $benarsalah='Benar';
            }else{
                $benarsalah='Salah';
            }
        $generatebanksoal_jawaban_id=generatebanksoal_jawaban::insertGetId(
            array(
                   'banksoaljawaban_id'     =>   $jawaban->id,
                   'pilihan'     =>   Fungsi::periksaabc($nomer),
                   'benarsalah'     =>   $benarsalah,
                   'generatebanksoal_detail_id'     =>   $generatebanksoal_detail_id,
                   'generatebanksoal_id'     =>   $generatebanksoal_id,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));

            }

            // dd($request,$ambilsoal->pluck('pertanyaan'),$ambiljawaban->pluck('nilai'));
        }






        // dd($request,$ambilsoal->pluck('pertanyaan'));

        return redirect()->route('dataajar.generatebanksoal',$dataajar->id)->with('status','Soal berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-trash');


    }
    public function destroy(dataajar $dataajar,generatebanksoal $id){

        generatebanksoal::destroy($id->id);
        generatebanksoal_detail::where('generatebanksoal_id',$id->id)->delete();
        generatebanksoal_jawaban::where('generatebanksoal_id',$id->id)->delete();

        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }
    public function pdfsoal(dataajar $dataajar,generatebanksoal $id){

        $datas=generatebanksoal_detail::where('generatebanksoal_id',$id->id)
        ->with('banksoal')
        ->get();
        // dd($databanksoaldetail,1%5);

        // $collection = new Collection();

        // foreach($databanksoaldetail as $dbs){

        //     $ambiljawaban=generatebanksoal_jawaban::with('banksoaljawaban')->whereNull('deleted_at')
        //     ->where('generatebanksoal_detail_id',$dbs->id)
        //     ->get();


        //     dd($ambiljawaban,1%5);
        // }

        // dd($collection);
        $tgl=date("YmdHis");
        $pdf = PDF::loadview('pages.admin.generatebanksoal.pdfsoal',compact('datas','dataajar','id'))->setPaper('a4', 'potrait');
        return $pdf->download('soalujian'.$tgl.'-pdf');

    }
    public function pdfkunci(dataajar $dataajar,generatebanksoal $id){

        $datas=generatebanksoal_detail::where('generatebanksoal_id',$id->id)->get();
        // dd($dataajar,$id,$datas,1%5);
        $tgl=date("YmdHis");
        $pdf = PDF::loadview('pages.admin.generatebanksoal.pdfkunci',compact('datas','dataajar','id'))->setPaper('a4', 'potrait');
        return $pdf->download('soalujian'.$tgl.'-pdf');

    }

    public function xml(dataajar $dataajar,generatebanksoal $id){
        // dd('xml');

        $datas=generatebanksoal_detail::where('generatebanksoal_id',$id->id)
        ->with('banksoal')
        ->get();

        return response()->view('pages.admin.generatebanksoal.xml',compact(
            'datas','dataajar','id'
        ))->header('Content-Type', 'application/xml; charset=utf-8')
        ->header('Content-Type', 'application/force-download')
        ->header('Content-Type', 'application/download')
        ->header('Content-Description', 'File Transfer')
        ->header('Content-Disposition', 'attachment; filename="banksoal-'.date('YmdHis').'.xml"')
        ->header('Expires', '0')
        ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
        ->header('Pragma', 'public');
    }
    public function exportsoal(dataajar $dataajar,Request $request){
        // $databanksoal=banksoal::where('dataajar_id',$dataajar->id)->get();
        // dd($databanksoal,$dataajar,'Export');
        $tgl=date("YmdHis");
		return Excel::download(new exportbanksoal($dataajar), 'sim-banksoal-'.$dataajar->id.'-'.$tgl.'.xlsx');
    }
    public function importsoal(dataajar $dataajar,Request $request){
        // dd('import');
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

		$file = $request->file('file');

		$nama_file = rand().$file->getClientOriginalName();

		$file->move('file_temp',$nama_file);

		Excel::import(new importbanksoalv2($dataajar), public_path('/file_temp/'.$nama_file));

        return redirect()->back()->with('status','Data berhasil Diimport!')->with('tipe','success')->with('icon','fas fa-edit');

    }
}
