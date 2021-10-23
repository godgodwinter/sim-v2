<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\banksoal;
use App\Models\dataajar;
use App\Models\mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
        $datas=banksoal::with('dataajar')->with('banksoaljawaban')
        ->where('dataajar_id',$dataajar->id)
        ->paginate(Fungsi::paginationjml());
// dd($datas);
        return view('pages.admin.banksoal.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='banksoal';

        return view('pages.admin.banksoal.create',compact('request','pages','dataajar'));
    }
    public function store(dataajar $dataajar,Request $request){
            $collection = new Collection();
            if($request->kategorisoal_nama==3){
                    $collection->push((object)['jawaban' => $request->jawaban1,
                                               'hasil'=>$request->jawaban_hasil1,
                    ]);

                    $collection->push((object)['jawaban' => $request->jawaban2,
                                               'hasil'=>$request->jawaban_hasil2,
                    ]);
            }
                if($request->jawaban1!=null){
                    $collection->push((object)['jawaban' => $request->jawaban1,
                                               'hasil'=>$request->jawaban_hasil1,
                    ]);
                }
                if($request->jawaban2!=null){
                    $collection->push((object)['jawaban' => $request->jawaban2,
                                               'hasil'=>$request->jawaban_hasil2,
                    ]);
                }
                if($request->jawaban3!=null){
                    $collection->push((object)['jawaban' => $request->jawaban3,
                                               'hasil'=>$request->jawaban_hasil3,
                    ]);
                }
                if($request->jawaban4!=null){
                    $collection->push((object)['jawaban' => $request->jawaban4,
                                               'hasil'=>$request->jawaban_hasil4,
                    ]);
                }
                if($request->jawaban5!=null){
                    $collection->push((object)['jawaban' => $request->jawaban5,
                                               'hasil'=>$request->jawaban_hasil5,
                    ]);
                }
        // dd($request,$collection);
        $kodegenerate=Uuid::uuid4()->getHex();
        $files = $request->file('file');

        if($files!=null){
        $data = file_get_contents($request->file);
        $encoded_data = base64_encode($data);
        // contoh export ganbar decode ke file assets/banksoal
        $decoded_data = base64_decode($encoded_data);
        // Show the decoded data
        // echo $decoded_data;
        $file = fopen("assets/banksoal/".$kodegenerate.".jpg", "w");
        // Insert the decoded$kodegenerate.  to the image file
        fwrite($file, $decoded_data);
        // Close the file
        fclose($file);

    }else{
        $encoded_data='';
    }


    function carinilai($kategorisoal_nama,$hasil){
        if(($kategorisoal_nama==1) && ($hasil=='Benar')){
                $data=100;
        }elseif(($kategorisoal_nama==2) && ($hasil=='Benar')){
                $data=50;
        }elseif(($kategorisoal_nama==3) && ($hasil=='Benar')){
                $data=100;
        }else{
            $data=0;
        }
        // dd($kategorisoal_nama,$hasil,$data);
    return $data;
}
    DB::table('banksoal')->insert(
        array(
            'pertanyaan'     =>   $request->pertanyaan,
            'nilai'     =>   100,
            'tingkatkesulitan'     =>   $request->tingkatkesulitan,
            'kategorisoal_nama'     =>   $request->kategorisoal_nama,
            'gambar'     =>   $encoded_data,
            'dataajar_id'     =>   $dataajar->id,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
        ));

    $ambilbanksoal=banksoal::orderBy('id','desc')->first();
    $banksoal_id=$ambilbanksoal->id;
// dd($request,$ambilbanksoal,$banksoal_id);
foreach($collection as $j){
    $nilai=carinilai($request->kategorisoal_nama,$j->hasil);
    // dd($nilai);
    DB::table('banksoaljawaban')->insert(
    array(
        'jawaban'     =>   $j->jawaban,
        'hasil'     =>   $j->hasil,
        'nilai'     =>   $nilai,
        'banksoal_id'     =>   $ambilbanksoal->id,
        'created_at'=>date("Y-m-d H:i:s"),
        'updated_at'=>date("Y-m-d H:i:s")
    ));

}

// dd($request,$collection);
return redirect()->back()->with('status','Soal berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-trash');



    }
}
