<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\nilaipelajaran;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class inputnilaicontroller extends Controller
{
    public function index(Request $request,$id){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $dataajar=DB::table('dataajar')->where('id',$id)->first();

        $pelajaran_nama=$dataajar->pelajaran_nama;
        $kelas_nama=$dataajar->kelas_nama;
        $tapel_nama=Fungsi::tapelaktif();

        $kodegenerate=Uuid::uuid4()->getHex();

        // dd($p_nama,$k_nama,$t_nama,$mp_nama,$kd_kode,$kd_tipe,$kodegenerate);

        #WAJIB
        $pages='inputnilai';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('banksoal')
                ->where('pelajaran_nama',$pelajaran_nama)
                ->where('kelas_nama',$kelas_nama)
                ->where('tapel_nama',$tapel_nama)
                // ->where('kode',1)
                // ->orWhere('pelajaran_nama',$p_nama)
                // ->where('kelas_nama',$k_nama)
                // ->where('tapel_nama',$t_nama)
                // ->where('kode',2)
                ->orderBy('created_at','desc')
        ->get();

        $datasiswa=DB::table('siswa')->where('kelas_nama',$kelas_nama)->get();
        $datakd=DB::table('kompetensidasar')
            ->where('kelas_nama',$kelas_nama)
            ->where('tapel_nama',$tapel_nama)
            ->where('pelajaran_nama',$pelajaran_nama)
            ->orderBy('kode','asc')
            ->orderBy('tipe','desc')
            ->get();

            // $datakd=$datakdtanpauniq->unique('kode');

        // $datas=$datastanpauniq->unique('kode');



        // $generate_kode=Fungsi::kompetensidasargeneratekode($t_nama,$k_nama,$p_nama);

        // 1. ambil datas dari tabel kompetensi dasar where tapel kelas dan pelajarannama
        // 1. ambil last id (Fungsi generatekompetesiid)
        // dd($request);

        return view('admin.inputnilaibaru.index',compact('pages','datas','request'
        ,'kodegenerate'
        ,'datasiswa'
        ,'datakd'
        ,'pelajaran_nama','kelas_nama','tapel_nama'
    ));

    }

    public function store(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama,$materipokok_nama,$kompetensidasar_kode,$kompetensidasar_tipe){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);
        $mp_nama=base64_decode($materipokok_nama);
        $kd_kode=base64_decode($kompetensidasar_kode);
        $kd_tipe=base64_decode($kompetensidasar_tipe);
        // 1. periksa apakah data sudah ada
        $cek=DB::table('nilaipelajaran')
                ->where('siswa_nis',$request->siswa_nis)
                ->where('materipokok_nama',$request->materipokok_nama)
                ->where('kompetensidasar_kode',$request->kompetensidasar_kode)
                ->where('kompetensidasar_tipe',$request->kompetensidasar_tipe)
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->count();
                // dd($request,$cek);
                // jika belum maka insert
                if($cek<1){
                    DB::table('nilaipelajaran')->insert(
                     array(
                            'siswa_nama'     =>   $request->siswa_nama,
                            'siswa_nis'     =>   $request->siswa_nis,
                            'nilai'     =>   $request->nilai,
                            'materipokok_nama'     =>   $request->materipokok_nama,
                            'kompetensidasar_kode'     =>   $request->kompetensidasar_kode,
                            'kompetensidasar_tipe'     =>   $request->kompetensidasar_tipe,
                            'pelajaran_nama'     =>   $p_nama,
                            'kelas_nama'     =>   $k_nama,
                            'tapel_nama'     =>   $t_nama,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                     ));

                }else{
                    // jika sudah maka update

                    nilaipelajaran::where('siswa_nis',$request->siswa_nis)
                        ->where('materipokok_nama',$request->materipokok_nama)
                        ->where('kompetensidasar_kode',$request->kompetensidasar_kode)
                        ->where('kompetensidasar_tipe',$request->kompetensidasar_tipe)
                        ->where('pelajaran_nama',$p_nama)
                        ->where('kelas_nama',$k_nama)
                        ->where('tapel_nama',$t_nama)
                        ->update([
                            'nilai'=>$request->nilai,
                        ]);

                }
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function apimultistore (Request $request){
        $output='';
        $datas='';
        $warna='';
        $first='';
        $alldatas=$request->ids;
        foreach($request->ids as $d){

        $strex=explode("^",$d);

            // dd($request,$d,$strex);

            $siswa_nama=$strex[0];
            $siswa_nis=$strex[1];
            $materipokok_nama=$strex[2];
            $kompetensidasar_kode=$strex[3];
            $kompetensidasar_tipe=$strex[4];
            $pelajaran_nama=$strex[5];
            $kelas_nama=$strex[6];
            $tapel_nama=$strex[7];


        $cek=DB::table('nilaipelajaran')
        ->where('siswa_nis',$siswa_nis)
        ->where('materipokok_nama',$materipokok_nama)
        ->where('kompetensidasar_kode',$kompetensidasar_kode)
        ->where('kompetensidasar_tipe',$kompetensidasar_tipe)
        ->where('pelajaran_nama',$pelajaran_nama)
        ->where('kelas_nama',$kelas_nama)
        ->where('tapel_nama',$tapel_nama)
        ->count();
        // dd($request,$cek);
        // jika belum maka insert
        if($cek<1){
            DB::table('nilaipelajaran')->insert(
             array(
                    'siswa_nama'     =>   $siswa_nama,
                    'siswa_nis'     =>   $siswa_nis,
                    'nilai'     =>   $request->nilaimulti,
                    'materipokok_nama'     =>   $materipokok_nama,
                    'kompetensidasar_kode'     =>   $kompetensidasar_kode,
                    'kompetensidasar_tipe'     =>   $kompetensidasar_tipe,
                    'pelajaran_nama'     =>   $pelajaran_nama,
                    'kelas_nama'     =>   $kelas_nama,
                    'tapel_nama'     =>   $tapel_nama,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
             ));

        }else{
            // jika sudah maka update

            nilaipelajaran::where('siswa_nis',$siswa_nis)
            ->where('materipokok_nama',$materipokok_nama)
            ->where('kompetensidasar_kode',$kompetensidasar_kode)
            ->where('kompetensidasar_tipe',$kompetensidasar_tipe)
            ->where('pelajaran_nama',$pelajaran_nama)
            ->where('kelas_nama',$kelas_nama)
            ->where('tapel_nama',$tapel_nama)
                ->update([
                    'nilai'     =>   $request->nilaimulti,
                ]);

        }

        }
        // $jmldata=count($strex);
        // dd('ok');
        $datasiswa=DB::table('siswa')->where('kelas_nama',$kelas_nama)->get();
        $datakd=DB::table('kompetensidasar')
            ->where('kelas_nama',$kelas_nama)
            ->where('tapel_nama',$tapel_nama)
            ->where('pelajaran_nama',$pelajaran_nama)
            ->orderBy('kode','asc')
            ->orderBy('tipe','desc')
            ->get();
            $no=1;
        foreach($datasiswa as $data){
            $outputambahan='';
            $outputavgp='';
            $outputavgk='';

            foreach($datakd as $dkd){

                $jmldatamateri=DB::table('materipokok')
                ->where('kelas_nama',$kelas_nama)
                ->where('tapel_nama',$tapel_nama)
                ->where('pelajaran_nama',$pelajaran_nama)
                ->where('kompetensidasar_nama',$dkd->nama)
                ->where('kompetensidasar_tipe',$dkd->tipe)
                ->where('kompetensidasar_kode',$dkd->kode)
                ->orderBy('created_at','asc')
                // ->orderBy('tipe','desc')
                ->count();

                $datamateri=DB::table('materipokok')
                ->where('kelas_nama',$kelas_nama)
                ->where('tapel_nama',$tapel_nama)
                ->where('pelajaran_nama',$pelajaran_nama)
                ->where('kompetensidasar_nama',$dkd->nama)
                ->where('kompetensidasar_tipe',$dkd->tipe)
                ->where('kompetensidasar_kode',$dkd->kode)
                ->orderBy('created_at','asc')
                // ->orderBy('tipe','desc')
                ->get();

                            if($dkd->tipe=='Pengetahuan'){
                                $kodeprefix=3;
                            }else{
                                $kodeprefix=4;
                            }

                            if($jmldatamateri>0){
                                foreach($datamateri as $dm){

                                    $cek=DB::table('nilaipelajaran')
                                    ->where('siswa_nis',$data->nis)
                                    ->where('materipokok_nama',$dm->nama)
                                    ->where('kompetensidasar_kode',$dkd->kode)
                                    ->where('kompetensidasar_tipe',$dkd->tipe)
                                    ->where('pelajaran_nama',$pelajaran_nama)
                                    ->where('kelas_nama',$kelas_nama)
                                    ->where('tapel_nama',$tapel_nama)
                                    ->count();

                                $tampilkan='-';
                                if($cek>0){

                                    $ambil=DB::table('nilaipelajaran')
                                            ->where('siswa_nis',$data->nis)
                                            ->where('materipokok_nama',$dm->nama)
                                            ->where('kompetensidasar_kode',$dkd->kode)
                                            ->where('kompetensidasar_tipe',$dkd->tipe)
                                            ->where('pelajaran_nama',$pelajaran_nama)
                                            ->where('kelas_nama',$kelas_nama)
                                            ->where('tapel_nama',$tapel_nama)
                                            ->first();
                                    $tampilkan=$ambil->nilai;
                                }

                                $outputambahan.='

                                            <td class="text-center"  style="vertical-align: middle;">
                                                <input type="checkbox" name="ids" class="checkBoxClass siswa'.$data->nis.' materi'.$dm->id.'" value="'.$data->nama.'^'.$data->nis.'^'.$dm->nama.'^'.$dkd->kode.'^'.$dkd->tipe.'^'.$pelajaran_nama.'^'.$kelas_nama.'^'.$tapel_nama.'" id="chkCheckAll'.$data->nama.'^'.$data->nis.'^'.$dm->nama.'^'.$dkd->kode.'^'.$dkd->tipe.'^'.$pelajaran_nama.'^'.$kelas_nama.'^'.$tapel_nama.'">
                                                <label for="chkCheckAll'.$data->nama.'^'.$data->nis.'^'.$dm->nama.'^'.$dkd->kode.'^'.$dkd->tipe.'^'.$pelajaran_nama.'^'.$kelas_nama.'^'.$tapel_nama.'"> '.$tampilkan.'</label>

                                            </td>
                                ';
                                // <input type="text" class="btn  btn-light btn-sm" data-toggle="modal"
                                // data-target="#modalinput'.$kodeprefix.'_'.$dkd->kode.'_'.$no.'_'.$data->nis.'" value="'.$tampilkan.'">

                                }

                            }else{
                                //jika materimasih kosong
                                $outputambahan.='<td class="text-center"> - </td>';

                            }



                            $ambiljmlnilai=DB::table('nilaipelajaran')
                            ->where('siswa_nis',$data->nis)
                            ->where('kompetensidasar_tipe','Pengetahuan')
                            ->where('pelajaran_nama',$pelajaran_nama)
                            ->where('kelas_nama',$kelas_nama)
                            ->where('tapel_nama',$tapel_nama)
                            ->sum('nilai');

                            $ambiljmldatanilai=DB::table('nilaipelajaran')
                                                ->where('siswa_nis',$data->nis)
                                                ->where('kompetensidasar_tipe','Pengetahuan')
                                                ->where('pelajaran_nama',$pelajaran_nama)
                                                ->where('kelas_nama',$kelas_nama)
                                                ->where('tapel_nama',$tapel_nama)
                                                ->count();

                                $hasil=0;
                                if($ambiljmldatanilai>0){
                                    $hasil=number_format(($ambiljmlnilai/$ambiljmldatanilai),2);
                                }
                            $outputavgp='

                            <td  style="vertical-align: middle;" class="text-center">

                            '.$hasil.'

                        </td>
                            ';




                            $ambiljmlnilai=DB::table('nilaipelajaran')
                            ->where('siswa_nis',$data->nis)
                            ->where('kompetensidasar_tipe','Ketrampilan')
                            ->where('pelajaran_nama',$pelajaran_nama)
                            ->where('kelas_nama',$kelas_nama)
                            ->where('tapel_nama',$tapel_nama)
                            ->sum('nilai');

                            $ambiljmldatanilai=DB::table('nilaipelajaran')
                                                ->where('siswa_nis',$data->nis)
                                                ->where('kompetensidasar_tipe','Ketrampilan')
                                                ->where('pelajaran_nama',$pelajaran_nama)
                                                ->where('kelas_nama',$kelas_nama)
                                                ->where('tapel_nama',$tapel_nama)
                                                ->count();

                                $hasil=0;
                                if($ambiljmldatanilai>0){
                                    $hasil=number_format(($ambiljmlnilai/$ambiljmldatanilai),2);
                                }
                            $outputavgk='

                            <td  style="vertical-align: middle;" class="text-center">

                            '.$hasil.'

                        </td>
                            ';



            }

            $output.='<tr>
            <td  style="vertical-align: middle;" class="text-center">'.$no++.'</td>
            <td class="text-capitalize">
            <input type="checkbox" id="chkCheckAll'.$data->nis.'"> <label for="chkCheckAll'.$data->nis.'"> '.$data->nama.'</label>
            </td>

<script>

$("#chkCheckAll'.$data->nis.'").click(function(){
    $(".siswa'.$data->nis.'").prop(\'checked\',$(this).prop(\'checked\'));
})
</script>
            '.$outputambahan.' '.$outputavgp.' '.$outputavgk.'
            </tr>
    ';

        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
            // 'status' => $data->status,
            'warna' => $warna,
            'datas' => $cek,
            'first' => $first
        ], 200);


    }
}
