<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\guru;
use App\Models\inputnilai;
use App\Models\kelas;
use App\Models\kompetensidasar;
use App\Models\mapel;
use App\Models\materipokok;
use App\Models\siswa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class siswadataajarcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='siswa'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();

        #WAJIB
        $pages='materibelajar';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('kelas_id',$datasiswa->kelas_id)
        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        $caridataajar=dataajar::where('kelas_id',$datasiswa->kelas_id)->get();

        return view('pages.siswa.dataajar.index',compact('datas','request','pages','guru','caridataajar'));
    }
    public function cari(Request $request)
    {
       // dd($request);
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        $cari=$request->cari;
        #WAJIB
        $pages='materibelajar';
        $datas=dataajar::with('guru')->with('kelas')->with('mapel')->where('kelas_id',$datasiswa->kelas_id)
        ->where('nama','like',"%".$request->mapel."%")

        ->paginate(Fungsi::paginationjml());
        $guru=guru::get();
        // $kelas=kelas::get();
        $caridataajar=dataajar::where('kelas_id',$datasiswa->kelas_id)->get();

        return view('pages.siswa.dataajar.index',compact('datas','request','pages','guru','caridataajar'));
    }
    public function materi(dataajar $dataajar, Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        #WAJIB
        $pages='silabus';
        $datas=kompetensidasar::with('dataajar')->with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.siswa.dataajar.materi',compact('datas','request','pages','dataajar','datasiswa'));
    }

    public function materidetail(dataajar $dataajar,kompetensidasar $kd, Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        #WAJIB
        $pages='banksoal';
        $datas=materipokok::with('kompetensidasar')
        ->where('kompetensidasar_id',$kd->id)
        ->orderBy('id','asc')
        ->paginate(Fungsi::paginationjml());
        // dd($datas);
        return view('pages.siswa.dataajar.materidetail',compact('datas','request','pages','kd','dataajar','datasiswa'));
    }

    public function detailpenilaian(dataajar $dataajar,Request $request)
    {
        // dd($id);

        #WAJIB
        $pages='penilaian';
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        $kelas_id=$datasiswa->kelas_id;
        $datasiswa=siswa::where('kelas_id',$dataajar->kelas_id)->where('id',$datasiswa->id)->paginate(Fungsi::paginationjml());
        $datakd=kompetensidasar::with('materipokok')
        ->where('dataajar_id',$dataajar->id)
        ->orderBy('kode','asc')
        ->get();
        // $datasnilai=new Collection();
        //     foreach($datasiswa as $siswa){
        //         $datasnilai->push((object)[
        //             'id' => $request->id1,
        //             'nomerinduk'=>$request->nomerinduk,
        //             'nama'=>$request->nama,
        //             'kelas_id'=>$request->kelas_id,
        //             'materipokok_id'=>'1',
        //             'nilai'=>'90'
        //         ]);
        //     }
        $datas=$datasiswa;

        // $datas = $datasiswa->map(function ($item, $key) {
        //     return $item * 2;
        // });
        // dd($datas);

        $mapel=mapel::where('id',$dataajar->mapel_id)->first();

        return view('pages.siswa.dataajar.detailpenilaian',compact('datas','request','pages','dataajar','datakd','mapel'));
    }
    public function lihatnilai( Request $request)
    {
        $pages='penilaian';
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        $kelas_id=$datasiswa->kelas_id;
        // 1.buat koleksion baru
        $dataakhir= new Collection();
        // 2.isi data kelas,mapel dan siswa

          $mapels=dataajar::with('guru')->with('kelas')->where('kelas_id',$kelas_id)->get();

          foreach($mapels as $mapel){
              $tuntas='Belum';
              $guru_nama=$mapel->guru!=null?$mapel->guru->nama:null;
              $kelas_nama=$mapel->kelas!=null?$mapel->kelas->tingkatan." ".$mapel->kelas->jurusan." ".$mapel->kelas->suffix :null;

        // 3.beriksa detail apakah sudah tuntas / belum
            $ambikd=kompetensidasar::where('dataajar_id',$mapel->id)->get();
            // dd($ambikd);
            $arr=[];
            foreach($ambikd as $kd){
                $ambilnilai=null;
                $ambilmateri=materipokok::where('kompetensidasar_id',$kd->id)->get();
                foreach($ambilmateri as $materi){
                    $ambilnilai=inputnilai::where('materipokok_id',$materi->id)->where('siswa_id',$datasiswa->id)->avg('nilai');
                    if($ambilnilai!=null){
                        array_push($arr,$ambilnilai);
                    }
                    // dd($arr,$ambilnilai);
                }
            }
            // dd($arr,$avg);
            if(array_sum($arr)<1){
                $avg=0;
            }else{
                $avg=array_sum($arr)/count($arr);
            }

        // 4. masukkan kedalam koleksion tadi
            // $ambildata = array(
            //     (object) [
            //       'id' => '1',
            //       'mapel' => $mapel->nama,
            //       'guru_nama' => $guru_nama,
            //       'kelas_nama' => $kelas_nama,
            //       'avg' => $avg,

            //     ]
            //   );

              $dataakhir->push((object)[
                'id' => $mapel->id,
                'mapel' => $mapel->nama,
                'guru_nama' => $guru_nama,
                'kelas_nama' => $kelas_nama,
                'avg' => $avg,

              ]);
              $datas=$dataakhir;
          }

        // dd('siswa/penilaian',$dataakhir,$mapels);
        return view('pages.siswa.dataajar.lihatnilai',compact('dataakhir','request','pages','datasiswa','datas'));

    }
    public function lihatnilai_yus( Request $request)
    {
        $datasiswa=siswa::where('nomerinduk',Auth::user()->nomerinduk)->first();
        #WAJIB
        $pages='penilaian';
        $collectionpenilaian='';
        $c= new Collection();
        // $datas=inputnilai::with('siswa')->with('materipokok')
        // ->where('siswa_id',$datasiswa->id)
        // ->orderBy('id','asc')
        // ->paginate(Fungsi::paginationjml());

        //  $datas=dataajar::with('mapel')->with('guru')

        //  ->where('kelas_id',$datasiswa->kelas_id)
        //  ->paginate(Fungsi::paginationjml());

        //   $dat=DB::select("select ma.nama as na, gur.nama as gu, AVG(inilai.nilai) as nil
        //                       FROM dataajar da INNER JOIN mapel ma on da.mapel_id=ma.id
        //                       INNER JOIN guru gur ON da.guru_id=gur.id
        //                       INNER JOIN kompetensidasar ko on da.id=ko.dataajar_id
        //                       INNER JOIN materipokok mo on ko.id=mo.id
        //                       INNER JOIN inputnilai inilai on mo.id=inilai.id
        //                       WHERE  inilai.siswa_id=".$datasiswa->id)
        //                       ;


        $c= new Collection();
        $datas=dataajar::with('mapel')->with('kelas')->with('guru')
        ->where('kelas_id',$datasiswa->kelas_id)
        ->orderBy('id','desc')
        ->get();

        foreach($datas as $d){
            $c->push($d);
            $k_dasar=kompetensidasar::where('dataajar_id',$d->id)->get();
            $ccc= new Collection();
                foreach($k_dasar as $k){

                    $mk=materipokok::where('kompetensidasar_id',$k->id);
                    $c->push($mk);
                        foreach($mk as $m){
                            $nilais=inputnilai::avg('nilai')->where('materipokok_id',$mk->id)->get();
                            $ccc->push((object)[
                                'id'=>$d->id,

                                //'kelas'=>$d->kelas->tingkatan,
                                //'guru'=>$d->guru->nama,
                                'nilai'=>$nilais
                            ]);
                        }
            }
            $c->push((object)[
                'id'=>$d->id,
                'nama'=>$d->nama,
                //'kelas'=>$d->kelas->tingkatan,
                //'guru'=>$d->guru->nama,
                'nilai'=>$ccc
            ]);

        }




        //     $collectionpenilaian = new Collection();

        // foreach($datas as $m){

        //     $collectionmaster = new Collection();
        //         $k_dasar=kompetensidasar::where('dataajar_id',$m->id)->get();

        //         foreach($k_dasar as $kd){
        //             $periksadata=DB::table('materipokok')
        //         ->where('kompetensidasar_id',$k_dasar->id)

        //         ->get();

        //         foreach($periksadata as $p){
        //             $nilai_=DB::table('inputnilai')
        //             ->where('materipokok_id',$p->id)->get();
        //         }

        //         if($nilai_->count()>0){
        //             $ambildata=$nilai_->first();
        //             $nilai=$nilai_->first()->avg('nilai');
        //         }else{
        //             $nilai=null;
        //         }

        //     $collectionmaster->push((object)[
        //         'id'=>$periksadata->id,

        //         'nilai'=>$nilai
        //     ]);

        //         }





        //     $collectionpenilaian->push((object)[
        //         'id'=>$m->id,
        //         'nama'=>$m->nama,
        //         'guru'=>$m->guru->nama,
        //         'master'=>$collectionmaster
        //     ]);
        // }
         dd($c);
        return view('pages.siswa.dataajar.lihatnilai',compact('collectionpenilaian','request','pages','datasiswa','datas'));
    }
}
