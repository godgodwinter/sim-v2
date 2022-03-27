<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\banksoal;
use App\Models\banksoaljawaban;
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
            if(Auth::user()->tipeuser!='admin'  AND Auth::user()->tipeuser!='guru'){
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
        $datas=banksoal::with('dataajar')->with('banksoaljawaban')
        ->where('dataajar_id',$dataajar->id)
        ->paginate(Fungsi::paginationjml());
// dd($datas);
        return view('pages.admin.banksoal.index',compact('datas','request','pages','dataajar'));
    }
    public function create(dataajar $dataajar, Request $request)
    {
        #WAJIB
        $pages='silabus';

        return view('pages.admin.banksoal.create',compact('request','pages','dataajar'));
    }
    public function store(dataajar $dataajar,Request $request){
            $collection = new Collection();
            if($request->kategorisoal_nama==3){
                    // dd($request);
                    if($request->jawaban_hasil1=='Benar'){
                        $collection->push((object)['jawaban' => 'Benar',
                                                   'hasil'=> 'Benar',
                        ]);

                        $collection->push((object)['jawaban' => 'Salah',
                                                   'hasil'=> 'Salah',
                        ]);

                    }else{
                        $collection->push((object)['jawaban' => 'Benar',
                                                   'hasil'=> 'Salah',
                        ]);

                        $collection->push((object)['jawaban' => 'Salah',
                                                   'hasil'=> 'Benar',
                        ]);

                    }
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
return redirect()->route('dataajar.banksoal',$dataajar->id)->with('status','Soal berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-trash');



    }
    public function edit(dataajar $dataajar,banksoal $id, Request $request)
    {
        #WAJIB
        $pages='silabus';

        return view('pages.admin.banksoal.edit',compact('request','pages','dataajar','id'));
    }

    public function update(dataajar $dataajar,banksoal $id,Request $request){
        // dd($request);

        banksoaljawaban::where('banksoal_id',$id->id)->delete();


        $collection = new Collection();
        if($request->kategorisoal_nama==3){
            // dd($request);
            if($request->jawaban_hasil=='Benar'){
                $collection->push((object)['jawaban' => 'Benar',
                                           'hasil'=> 'Benar',
                ]);

                $collection->push((object)['jawaban' => 'Salah',
                                           'hasil'=> 'Salah',
                ]);

            }else{
                $collection->push((object)['jawaban' => 'Benar',
                                           'hasil'=> 'Salah',
                ]);

                $collection->push((object)['jawaban' => 'Salah',
                                           'hasil'=> 'Benar',
                ]);

            }
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

banksoal::where('id',$id->id)
->update([
    'pertanyaan'     =>   $request->pertanyaan,
    'nilai'     =>   100,
    'tingkatkesulitan'     =>   $request->tingkatkesulitan,
    'kategorisoal_nama'     =>   $request->kategorisoal_nama,
    'gambar'     =>   $encoded_data,
   'updated_at'=>date("Y-m-d H:i:s")
]);

// dd($request,$ambilbanksoal,$banksoal_id);
foreach($collection as $j){
$nilai=carinilai($request->kategorisoal_nama,$j->hasil);
// dd($nilai);
DB::table('banksoaljawaban')->insert(
array(
    'jawaban'     =>   $j->jawaban,
    'hasil'     =>   $j->hasil,
    'nilai'     =>   $nilai,
    'banksoal_id'     =>   $id->id,
    'created_at'=>date("Y-m-d H:i:s"),
    'updated_at'=>date("Y-m-d H:i:s")
));

}

// dd($request,$collection);
return redirect()->route('dataajar.banksoal',$dataajar->id)->with('status','Soal berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-trash');



}

public function destroy(dataajar $dataajar,banksoal $id){

    banksoal::destroy($id->id);
    banksoaljawaban::where('banksoal_id',$id->id)->delete();
    return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

}

public function multidel(dataajar $dataajar,Request $request)
{

    $ids=$request->ids;
    banksoal::whereIn('id',$ids)->delete();
    banksoaljawaban::whereIn('banksoal_id',$ids)->delete();

    // load ulang
    #WAJIB
        $pages='banksoal';
        $datas=banksoal::with('dataajar')->with('banksoaljawaban')
        ->where('dataajar_id',$dataajar->id)
        ->paginate(Fungsi::paginationjml());
// dd($datas);
        return view('pages.admin.banksoal.index',compact('datas','request','pages','dataajar'));

}
}
