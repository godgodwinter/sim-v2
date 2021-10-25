<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\banksoal;
use App\Models\banksoaljawaban;
use App\Models\dataajar;
use App\Models\generatebanksoal;
use App\Models\generatebanksoal_detail;
use App\Models\generatebanksoal_jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    $pages='banksoal';
    $datas=generatebanksoal::with('dataajar')
    ->where('dataajar_id',$dataajar->id)
    ->paginate(Fungsi::paginationjml());
// dd($datas);
    return view('pages.admin.generatebanksoal.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='banksoal';

        return view('pages.admin.generatebanksoal.create',compact('request','pages','dataajar'));
    }

    public function store(dataajar $dataajar,Request $request){

        $soalacak=$request->soal;
        $jawabanacak=$request->jawaban;
        // $nomer=4;
        //     dd(Fungsi::periksaabc($nomer));
        $generatebanksoal_id=generatebanksoal::insertGetId(
            array(
                   'jml'     =>   $request->jml,
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
}
