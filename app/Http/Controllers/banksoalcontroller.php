<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\banksoal;
use App\Models\banksoal_jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;
use Exception;
use Illuminate\Support\Facades\Storage;

class banksoalcontroller extends Controller
{
    public function index(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama,$materipokok_nama,$kompetensidasar_kode,$kompetensidasar_tipe){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);
        $mp_nama=base64_decode($materipokok_nama);
        $kd_kode=base64_decode($kompetensidasar_kode);
        $kd_tipe=base64_decode($kompetensidasar_tipe);

        $kodegenerate=Uuid::uuid4()->getHex();

        // dd($p_nama,$k_nama,$t_nama,$mp_nama,$kd_kode,$kd_tipe,$kodegenerate);

        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('banksoal')
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->where('materipokok_nama',$mp_nama)
                ->where('kompetensidasar_kode',$kd_kode)
                ->where('kompetensidasar_tipe',$kd_tipe)
                // ->where('kode',1)
                // ->orWhere('pelajaran_nama',$p_nama)
                // ->where('kelas_nama',$k_nama)
                // ->where('tapel_nama',$t_nama)
                // ->where('kode',2)
                ->orderBy('created_at','desc')
        ->get();

        // $datas=$datastanpauniq->unique('kode');



        // $generate_kode=Fungsi::kompetensidasargeneratekode($t_nama,$k_nama,$p_nama);


        // 1. ambil datas dari tabel kompetensi dasar where tapel kelas dan pelajarannama
        // 1. ambil last id (Fungsi generatekompetesiid)


        return view('admin.banksoal.index',compact('pages','datas','request'
        ,'kodegenerate'
        ,'pelajaran_nama','kelas_nama','tapel_nama'
        ,'materipokok_nama'
        ,'kompetensidasar_kode'
        ,'kompetensidasar_tipe'
    ));

    }
    //


    public function store(Request $request,$pelajaran_nama,$kelas_nama,$tapel_nama,$materipokok_nama,$kompetensidasar_kode,$kompetensidasar_tipe){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $kodegenerate=Uuid::uuid4()->getHex();
        // dd($request);
        $a=0;

        // $path = 'myfolder/myimage.png';
// 		$file = $request->file('file');
// 		$path=$file->getRealPath();
// $type = pathinfo($path, PATHINFO_EXTENSION);
// $data = file_get_contents($path);
// $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
// // dd($base64);

// // $img = $_POST['img'];
// $img = str_replace('data:image/png;base64,', '', $base64);
// $img = str_replace(' ', '+', $img);
// $data = base64_decode($img);
// $file =  uniqid() . '.png';
// $success = file_put_contents($file, $data);
// dd($success);
		// $file = $request->file('file');

//         // nama file
        // $data=$file->getClientOriginalName();
        // dd($request);
// echo 'File Name: '.$file->getClientOriginalName();

        $files = $request->file('file');

        if($files!=null){
        $data = file_get_contents($request->file);


        $encoded_data = base64_encode($data);

    }else{
        $encoded_data='';
    }
        // contoh export ganbar decode ke file assets/banksoal
        $decoded_data = base64_decode($encoded_data);
        // Show the decoded data
        // echo $decoded_data;
        $file = fopen("assets/banksoal/".$kodegenerate.".jpg", "w");
        // Insert the decoded$kodegenerate.  to the image file
        fwrite($file, $decoded_data);
        // Close the file
        fclose($file);

        // dd($encoded_data);
        // dd($request->file('file'));
        $p_nama=base64_decode($pelajaran_nama);
        $k_nama=base64_decode($kelas_nama);
        $t_nama=base64_decode($tapel_nama);
        $mp_nama=base64_decode($materipokok_nama);
        $kd_kode=base64_decode($kompetensidasar_kode);
        $kd_tipe=base64_decode($kompetensidasar_tipe);


    //    dd($request->tingkatkesulitan);

        //input jawaban soal
        function inputsoal($kategorisoal_nama,$kodegenerate,$nilai,$jawaban,$hasil){
            // $a=$jawaban;
            // return $a;
            if($jawaban!=null && $jawaban!=''){
            DB::table('banksoal_jawaban')->insert(
                array(
                    'jawaban'     =>   $jawaban,
                    'hasil'     =>   $hasil,
                    'nilai'     =>   $nilai,
                    'kategorisoal_nama'     =>   $kategorisoal_nama,
                    'kodegenerate'     =>   $kodegenerate,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ));
            }
        }

        function carinilai($kategorisoal_nama,$hasil){
                if(($kategorisoal_nama==1) && ($hasil=='benar')){
                        $data=100;
                }elseif(($kategorisoal_nama==2) && ($hasil=='benar')){
                        $data=50;
                }elseif(($kategorisoal_nama==3) && ($hasil=='benar')){
                        $data=100;
                }else{
                    $data=0;
                }
                // dd($kategorisoal_nama,$hasil);
            return $data;
        }

        if($request->kategorisoal_nama==1){
            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil1);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban1,$request->jawaban_hasil1);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil2);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban2,$request->jawaban_hasil2);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil3);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban3,$request->jawaban_hasil3);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil4);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban4,$request->jawaban_hasil4);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil5);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban5,$request->jawaban_hasil5);

        }elseif($request->kategorisoal_nama==2){

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil1);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban1,$request->jawaban_hasil1);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil2);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban2,$request->jawaban_hasil2);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil3);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban3,$request->jawaban_hasil3);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil4);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban4,$request->jawaban_hasil4);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil5);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban5,$request->jawaban_hasil5);


        }else{

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil1);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban1,$request->jawaban_hasil1);

            $nilai=carinilai($request->kategorisoal_nama,$request->jawaban_hasil2);
            inputsoal($request->kategorisoal_nama,$kodegenerate,$nilai,$request->jawaban2,$request->jawaban_hasil2);

        }


        // dd('terakir',$nilai,$request->jawaban1);



       DB::table('banksoal')->insert(
        array(
               'pertanyaan'     =>   $request->pertanyaan,
               'nilai'     =>   100,
               'tingkatkesulitan'     =>   $request->tingkatkesulitan,
               'kategorisoal_nama'     =>   $request->kategorisoal_nama,
               'tingkatkesulitanangka'     =>   0,
               'kodegenerate'     =>   $kodegenerate,
               'gambar'     =>   $encoded_data,
               'kompetensidasar_tipe'     =>   $kd_tipe,
               'materipokok_nama'     =>   $mp_nama,
               'kompetensidasar_kode'     =>   $kd_kode,
               'pelajaran_nama'     =>   $p_nama,
               'kelas_nama'     =>   $k_nama,
               'tapel_nama'     =>   $t_nama,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));


        //jika ada gambar maka upload

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');


    }
    public function uploadgambar(banksoal $id)
    {

    }
    public function show(banksoal $id)
    {
        // dd($id);
        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas=$id;


        // $datas=DB::table('kategori')->orderBy('prefix','asc')->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        // $jmldata = DB::table('kategori')->count();

        return view('admin.banksoal.edit',compact('pages','datas'));
    }


    public function proses_update($request,$id){

        // dd($tapel);
        $kodegenerate=$id->kodegenerate;
        $request->validate([
            'pertanyaan'=>'required'
        ],
        [
            'pertanyaan.required'=>'pertanyaan Harus diisi',


        ]);


        $files = $request->file('file');

        if($files!=null){
        $data = file_get_contents($request->file);


        $encoded_data = base64_encode($data);

    }else{
        $encoded_data='';
    }
        // contoh export ganbar decode ke file assets/banksoal
        $decoded_data = base64_decode($encoded_data);
        // Show the decoded data
        // echo $decoded_data;
        $file = fopen("assets/banksoal/".$kodegenerate.".jpg", "w");
        // Insert the decoded$kodegenerate.  to the image file
        fwrite($file, $decoded_data);
        // Close the file
        fclose($file);

         //aksi update
        banksoal::where('id',$id->id)
            ->update([
                'pertanyaan'=>$request->pertanyaan,
                'kategorisoal_nama'=>$request->kategorisoal_nama,
                'gambar'=>$encoded_data,
                'tingkatkesulitan'=>$request->tingkatkesulitan,
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

         //aksi update
         banksoal_jawaban::where('kodegenerate',$id->kodegenerate)
        ->update([
            'kategorisoal_nama'=>$request->kategorisoal_nama,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);
    }

    public function update(Request $request, banksoal $id)
    {
        // dd($request);
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        banksoal::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    }


    public function detail(banksoal $id)
    {
        // dd($id);
        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        // $datas=$id;
        $datas=$id;

        $datajawaban=DB::table('banksoal_jawaban')->where('kodegenerate',$id->kodegenerate)->orderBy('created_at','asc')->get();
        // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        // $jmldata = DB::table('kategori')->count();

        return view('admin.banksoal.detail',compact('pages','datas','datajawaban'));
    }

    public function detailstore(Request $request,banksoal $id){

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        $kategorisoal_nama=$id->kategorisoal_nama;
        $nilai=0;
        $hasil=$request->hasil;
        // dd($request,$id->kategorisoal_nama);

        if($id->kategorisoal_nama==1){
            // 1.cek jika jawaban benar sudah ada 1 maka kembali
            if($hasil=='benar'){
            $jmlbenar=DB::table('banksoal_jawaban')->where('hasil',$hasil)->where('kategorisoal_nama',$id->kategorisoal_nama)->where('kodegenerate',$id->kodegenerate)->count();
                if($jmlbenar>=1){

                        return redirect()->back()->with('status','Gagal, Sudah ada 1 jawaban benar!')->with('tipe','warning')->with('icon','fas fa-feather');

                }
                //benar nilai 100
                $nilai=100;
            }else{
                   // 2.cek jika jawaban salah ada 4 maka kembali
            $jmljawaban=DB::table('banksoal_jawaban')->where('hasil',$hasil)->where('kodegenerate',$id->kodegenerate)->count();
            if($jmljawaban>=4){

                return redirect()->back()->with('status','Gagal Sudah ada 4 jawaban salah!')->with('tipe','warning')->with('icon','fas fa-feather');
            }
            }


            // dd('pilihanganda',$jmlbenar,$jmljawaban);

            // update nilai benar adalah 100
        }elseif($id->kategorisoal_nama==2){
            // 1.cek jika jawaban benar sudah ada 2 maka kembali
            if($hasil=='benar'){
            $jmlbenar=DB::table('banksoal_jawaban')->where('hasil',$hasil)->where('kategorisoal_nama',$id->kategorisoal_nama)->where('kodegenerate',$id->kodegenerate)->count();
                if($jmlbenar>=2){

                        return redirect()->back()->with('status','Gagal, Sudah ada 2 jawaban benar!')->with('tipe','warning')->with('icon','fas fa-feather');

                }
                //update nilai benar adalah 50
                $nilai=50;
            }else{
                   // 2.cek jika jawaban salah ada 3 maka kembali
            $jmljawaban=DB::table('banksoal_jawaban')->where('hasil',$hasil)->where('kodegenerate',$id->kodegenerate)->count();
            if($jmljawaban>=3){

                return redirect()->back()->with('status','Gagal Sudah ada 3 jawaban salah!')->with('tipe','warning')->with('icon','fas fa-feather');
            }
            }

        }else{
            // 1.cek jika jawaban benar sudah ada 1 maka kembali
            if($hasil=='benar'){
            $jmlbenar=DB::table('banksoal_jawaban')->where('hasil',$hasil)->where('kategorisoal_nama',$id->kategorisoal_nama)->where('kodegenerate',$id->kodegenerate)->count();
                if($jmlbenar>=1){

                        return redirect()->back()->with('status','Gagal, Sudah ada 1 jawaban benar!')->with('tipe','warning')->with('icon','fas fa-feather');

                }
                //update nilai benar adalah 100
                $nilai=100;
            }else{
                   // 2.cek jika jawaban salah ada 1 maka kembali
            $jmljawaban=DB::table('banksoal_jawaban')->where('hasil',$hasil)->where('kodegenerate',$id->kodegenerate)->count();
            if($jmljawaban>=1){

                return redirect()->back()->with('status','Gagal Sudah ada 1 jawaban salah!')->with('tipe','warning')->with('icon','fas fa-feather');
            }
            }
        }

        // 1.periksa data banksoaljawaban cek apakah sudah ada jawaban benar jika ada maka kembali
        // 2
        // $kodegenerate=Uuid::uuid4()->getHex();

    //    dd($request->tingkatkesulitan);

       DB::table('banksoal_jawaban')->insert(
        array(
               'jawaban'     =>   $request->jawaban,
               'nilai'     =>   $nilai,
               'hasil'     =>   $hasil,
               'kategorisoal_nama'     =>   $id->kategorisoal_nama,
               'kodegenerate'     =>   $id->kodegenerate,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');


    }
    public function detailshow(banksoal_jawaban $id)
    {
        // dd($id);
        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas=$id;
        // dd($id);
        $databanksoal=DB::table('banksoal')->where('kodegenerate',$id->kodegenerate)->orderBy('created_at','desc')->first();
        $banksoal_id=$databanksoal->id;
        // dd($banksoal_id);
        // $datas=DB::table('kategori')->orderBy('prefix','asc')->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        // $jmldata = DB::table('kategori')->count();

        return view('admin.banksoal.detailedit',compact('pages','datas','banksoal_id'));
    }

    public function detailproses_update($request,$id){

        // dd($tapel);

        $request->validate([
            'jawaban'=>'required'
        ],
        [
            'jawaban.required'=>'jawaban Harus diisi',


        ]);
         //aksi update
        // dd($id,$request);
        // $kategorisoal_nama=$id->kategorisoal_nama;
        $nilai=0;
        $hasil=$request->hasil;
        $kategorisoal_nama=$id->kategorisoal_nama;
        // dd($request,$id->kategorisoal_nama);

        if($kategorisoal_nama==1){
            // 1.cek jika jawaban benar sudah ada 1 maka kembali
            if($hasil=='benar'){

                //benar nilai 100
                $nilai=100;
            }else{
                   // 2.cek jika jawaban salah ada 4 maka kembali

            }


            // dd('pilihanganda',$jmlbenar,$jmljawaban);

            // update nilai benar adalah 100
        }elseif($kategorisoal_nama==2){
            // 1.cek jika jawaban benar sudah ada 2 maka kembali
            if($hasil=='benar'){

                //update nilai benar adalah 50
                $nilai=50;
            }else{
                   // 2.cek jika jawaban salah ada 3 maka kembali

            }

        }else{
            // 1.cek jika jawaban benar sudah ada 1 maka kembali
            if($hasil=='benar'){

                //update nilai benar adalah 100
                $nilai=100;
            }else{

            }
        }

        // dd($id->kategorisoal_nama,$nilai,$id);

        banksoal_jawaban::where('id',$id->id)
            ->update([
                'jawaban'=>$request->jawaban,
                'nilai'=>$nilai,
                'hasil'=>$request->hasil,
            ]);
    }

    public function detailupdate(Request $request, banksoal_jawaban $id)
    {
        // dd($request);
        // dd($request);
        $this->detailproses_update($request,$id);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function detaildestroy($id)
    {
        banksoal_jawaban::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    }



    public function generateworldsoal(Request $request){
    // dd($request);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        // $header = array('size' => 16, 'bold' => true);
        $header = array('size' => 11, 'bold' => false);
        $sebelastebal = array('size' => 11, 'bold' => true);
        $sebelasbiasa = array('size' => 11, 'bold' => false);
        $sebelasbiasaitalic = array('size' => 11, 'bold' => false,'italic' => true);
        $sebelasbiruitalic = array('size' => 11, 'bold' => false,'italic' => true,'color' => '0A4E83');
        $duabelastimesnew = array('size' => 12, 'bold' => false,'name'=>'Times New Roman');
        //ISIDATA


        $section->addText('Question 01', $header);
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000',
                            'cellMargin'=>0,
                            'spaceBefore' => 0,
                            'spaceAfter' => 0,
                            'marginTop'     => -1,
                            'marginLeft'    => -1,
                            'marginBottom'     => -1,
                            'marginRight'    => -1,
                            'spacing' => 0);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFFFF');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3,
                            'valign' => 'center',
                            'borderTopColor' =>'000000',
                            'borderTopSize' => 6,
                            'borderRightColor' =>'000000',
                            'borderRightSize' => 6,
                            'borderBottomColor' =>'000000',
                            'borderBottomSize' => 6,
                            'borderLeftColor' =>'000000',
                            'borderLeftSize' => 6
                        );
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellHCenteredright = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
        $cellHCenteredleft = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
        $cellVCentered = array('valign' => 'center');

        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);

        $table->addRow();

        $cell1 = $table->addCell(6000, $cellColSpan);
        $textrun1 = $cell1->addTextRun($cellHCenteredleft);
        $textrun1->addText('Pertanyaan Soal!!', $duabelastimesnew);    //3 colspan
        $table->addCell(700, $cellVCentered)->addText('MC', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Default mark:', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('1',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Shuffle the choices?', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('No',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Number the choices?', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('A',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Penalty for each incorrect try:', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('33.3',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(600, $cellVCentered)->addText('#', $sebelastebal, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Answer', $sebelastebal, $cellHCentered);
        $table->addCell(3000, $cellVCentered)->addText('Feedback', $sebelastebal, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('Grade', $sebelastebal, $cellHCentered);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('A.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('B.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('C.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('D.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);


        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('E.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('100', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('General feedback:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);


        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('For any correct response:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('Your answer is correct.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('For any incorrect response:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('Your answer is incorrect.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Hint 1:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Show the number of correct responses (Hint 1):', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('No', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Clear incorrect responses (Hint 1):', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('No', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Tags:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);


        $table->addRow();

        $cell1 = $table->addCell(6000, $cellColSpan);
        $textrun1 = $cell1->addTextRun($cellHCenteredleft);
        $textrun1->addText('Allows the selection of a single or multiple responses from a pre-defined list. (MC/MA)', $sebelasbiasaitalic);    //3 colspan
        $table->addCell(700, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        // $section->addPageBreak();  //untuk ganti halaman

        //END-ISIDATA
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('sim-generate.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('sim-generate.docx'));

    }

    public function generateworldsoallooping(Request $request){
    // dd($request);
        $p_nama=base64_decode($request->pelajaran_nama);
        $k_nama=base64_decode($request->kelas_nama);
        $t_nama=base64_decode($request->tapel_nama);
        $mp_nama=base64_decode($request->materipokok_nama);
        $kd_kode=base64_decode($request->kompetensidasar_kode);
        $kd_tipe=base64_decode($request->kompetensidasar_tipe);

    $ambildata=DB::table('banksoal')
    ->where('pelajaran_nama',$p_nama)
    ->where('kelas_nama',$k_nama)
    ->where('tapel_nama',$t_nama)
    ->where('materipokok_nama',$mp_nama)
    ->where('kompetensidasar_kode',$kd_kode)
    ->where('kompetensidasar_tipe',$kd_tipe)
    ->orderBy('created_at','desc')
    ->get();
    // dd($ambildata);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        // $header = array('size' => 16, 'bold' => true);
        $header = array('size' => 11, 'bold' => false);
        $sebelastebal = array('size' => 11, 'bold' => true);
        $sebelasbiasa = array('size' => 11, 'bold' => false);
        $sebelasbiasaitalic = array('size' => 11, 'bold' => false,'italic' => true);
        $sebelasbiruitalic = array('size' => 11, 'bold' => false,'italic' => true,'color' => '0A4E83');
        $duabelastimesnew = array('size' => 12, 'bold' => false,'name'=>'Times New Roman');
        //ISIDATA
$no=0;
foreach($ambildata as $data){
    $no++;
        $section->addText('Question '.$no, $header);
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000',
                            'cellMargin'=>0,
                            'spaceBefore' => 0,
                            'spaceAfter' => 0,
                            'marginTop'     => -1,
                            'marginLeft'    => -1,
                            'marginBottom'     => -1,
                            'marginRight'    => -1,
                            'spacing' => 0);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFFFF');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3,
                            'valign' => 'center',
                            'borderTopColor' =>'000000',
                            'borderTopSize' => 6,
                            'borderRightColor' =>'000000',
                            'borderRightSize' => 6,
                            'borderBottomColor' =>'000000',
                            'borderBottomSize' => 6,
                            'borderLeftColor' =>'000000',
                            'borderLeftSize' => 6
                        );
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellHCenteredright = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
        $cellHCenteredleft = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
        $cellVCentered = array('valign' => 'center');

        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);

        $table->addRow();

        $cell1 = $table->addCell(6000, $cellColSpan);
        $textrun1 = $cell1->addTextRun($cellHCenteredleft);
        $textrun1->addText($data->pertanyaan, $duabelastimesnew);    //3 colspan
        $table->addCell(700, $cellVCentered)->addText('MC', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Default mark:', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('1',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Shuffle the choices?', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('No',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Number the choices?', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('A',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $cell3 = $table->addCell(2000, $cellColSpan);
        $textrun2 = $cell3->addTextRun($cellHCenteredright);
        $textrun2->addText('Penalty for each incorrect try:', $sebelastebal);
        $table->addCell(700, $cellRowSpan)->addText('33.3',$sebelasbiasa, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(600, $cellVCentered)->addText('#', $sebelastebal, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Answer', $sebelastebal, $cellHCentered);
        $table->addCell(3000, $cellVCentered)->addText('Feedback', $sebelastebal, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('Grade', $sebelastebal, $cellHCentered);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('A.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan 1', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('B.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan 2', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('C.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan 3', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('D.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan 4', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('0', $sebelasbiruitalic, $cellHCenteredleft);


        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('E.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Mengatasi Perbedaan 5', $duabelastimesnew, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('100', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('General feedback:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', null, $cellHCentered);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);


        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('For any correct response:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('Your answer is correct.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('For any incorrect response:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('Your answer is incorrect.', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Hint 1:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Show the number of correct responses (Hint 1):', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('No', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Clear incorrect responses (Hint 1):', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('No', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $table->addRow();
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(4000, $cellVCentered)->addText('Tags:', $sebelastebal, $cellHCenteredleft);
        $table->addCell(3000, $cellVCentered)->addText('', $sebelasbiasa, $cellHCenteredleft);
        $table->addCell(500, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);


        $table->addRow();

        $cell1 = $table->addCell(6000, $cellColSpan);
        $textrun1 = $cell1->addTextRun($cellHCenteredleft);
        $textrun1->addText('Allows the selection of a single or multiple responses from a pre-defined list. (MC/MA)', $sebelasbiasaitalic);    //3 colspan
        $table->addCell(700, $cellVCentered)->addText('', $sebelasbiruitalic, $cellHCenteredleft);

        $section->addPageBreak();  //untuk ganti halaman
    }


        //END-ISIDATA
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('sim-generate.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('sim-generate.docx'));

    }

//     public function generateDocx()
//     {
//         $phpWord = new \PhpOffice\PhpWord\PhpWord();
//         $section = $phpWord->addSection();
//         $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
// tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
// quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
// consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
// cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
// proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
//         $section->addImage("https://ilmucoding.com/wp-content/uploads/2020/01/Tutorial-Belajar-Framework-Laravel.jpg");
//         $section->addText($description);
//         $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//         try {
//             $objWriter->save(storage_path('helloWorld.docx'));
//         } catch (Exception $e) {
//         }
//         return response()->download(storage_path('helloWorld.docx'));
//     }


    public function generateDocx()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $section->addImage("https://ilmucoding.com/wp-content/uploads/2020/01/Tutorial-Belajar-Framework-Laravel.jpg");
        $section->addText($description);
        // Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

        $section = $phpWord->addSection();
$header = array('size' => 16, 'bold' => true);

// 1. Basic table

$rows = 10;
$cols = 5;
$section->addText('Basic table', $header);

$table = $section->addTable();
for ($r = 1; $r <= $rows; $r++) {
    $table->addRow();
    for ($c = 1; $c <= $cols; $c++) {
        $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
    }
}

// 2. Advanced table

$section->addTextBreak(1);
$section->addText('Fancy table', $header);

$fancyTableStyleName = 'Fancy Table';
$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50);
$fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
$fancyTableCellStyle = array('valign' => 'center');
$fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
$fancyTableFontStyle = array('bold' => true);
$phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
$table = $section->addTable($fancyTableStyleName);
$table->addRow(900);
$table->addCell(2000, $fancyTableCellStyle)->addText('Row 1', $fancyTableFontStyle);
$table->addCell(2000, $fancyTableCellStyle)->addText('Row 2', $fancyTableFontStyle);
$table->addCell(2000, $fancyTableCellStyle)->addText('Row 3', $fancyTableFontStyle);
$table->addCell(2000, $fancyTableCellStyle)->addText('Row 4', $fancyTableFontStyle);
$table->addCell(500, $fancyTableCellBtlrStyle)->addText('Row 5', $fancyTableFontStyle);
for ($i = 1; $i <= 8; $i++) {
    $table->addRow();
    $table->addCell(2000)->addText("Cell {$i}");
    $table->addCell(2000)->addText("Cell {$i}");
    $table->addCell(2000)->addText("Cell {$i}");
    $table->addCell(2000)->addText("Cell {$i}");
    $text = (0 == $i % 2) ? 'X' : '';
    $table->addCell(500)->addText($text);
}

/*
 *  3. colspan (gridSpan) and rowspan (vMerge)
 *  ---------------------
 *  |     |   B    |    |
 *  |  A  |--------|  E |
 *  |     | C |  D |    |
 *  ---------------------
 */

$section->addPageBreak();
$section->addText('Table with colspan and rowspan', $header);

$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
$cellRowContinue = array('vMerge' => 'continue');
$cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
$cellVCentered = array('valign' => 'center');

$spanTableStyleName = 'Colspan Rowspan';
$phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
$table = $section->addTable($spanTableStyleName);

$table->addRow();

$cell1 = $table->addCell(2000, $cellRowSpan);
$textrun1 = $cell1->addTextRun($cellHCentered);
$textrun1->addText('A');
$textrun1->addFootnote()->addText('Row span');

$cell2 = $table->addCell(4000, $cellColSpan);
$textrun2 = $cell2->addTextRun($cellHCentered);
$textrun2->addText('B');
$textrun2->addFootnote()->addText('Column span');

$table->addCell(2000, $cellRowSpan)->addText('E', null, $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(2000, $cellVCentered)->addText('C', null, $cellHCentered);
$table->addCell(2000, $cellVCentered)->addText('D', null, $cellHCentered);
$table->addCell(null, $cellRowContinue);

/*
 *  4. colspan (gridSpan) and rowspan (vMerge)
 *  ---------------------
 *  |     |   B    |  1 |
 *  |  A  |        |----|
 *  |     |        |  2 |
 *  |     |---|----|----|
 *  |     | C |  D |  3 |
 *  ---------------------
 * @see https://github.com/PHPOffice/PHPWord/issues/806
 */

$section->addPageBreak();
$section->addText('Table with colspan and rowspan', $header);

$styleTable = array('borderSize' => 6, 'borderColor' => '999999');
$phpWord->addTableStyle('Colspan Rowspan', $styleTable);
$table = $section->addTable('Colspan Rowspan');

$row = $table->addRow();
$row->addCell(1000, array('vMerge' => 'restart'))->addText('A');
$row->addCell(1000, array('gridSpan' => 2, 'vMerge' => 'restart'))->addText('B');
$row->addCell(1000)->addText('1');

$row = $table->addRow();
$row->addCell(1000, array('vMerge' => 'continue'));
$row->addCell(1000, array('vMerge' => 'continue', 'gridSpan' => 2));
$row->addCell(1000)->addText('2');

$row = $table->addRow();
$row->addCell(1000, array('vMerge' => 'continue'));
$row->addCell(1000)->addText('C');
$row->addCell(1000)->addText('D');
$row->addCell(1000)->addText('3');

// 5. Nested table

$section->addTextBreak(2);
$section->addText('Nested table in a centered and 50% width table.', $header);

$table = $section->addTable(array('width' => 50 * 50, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
$cell = $table->addRow()->addCell();
$cell->addText('This cell contains nested table.');
$innerCell = $cell->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER))->addRow()->addCell();
$innerCell->addText('Inside nested table');



        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('helloWorld.docx'));
    }


    public function generatetxt(Request $request){
        // dd($request);
            $p_nama=base64_decode($request->pelajaran_nama);
            $k_nama=base64_decode($request->kelas_nama);
            $t_nama=base64_decode($request->tapel_nama);
            $mp_nama=base64_decode($request->materipokok_nama);
            $kd_kode=base64_decode($request->kompetensidasar_kode);
            $kd_tipe=base64_decode($request->kompetensidasar_tipe);
        $output='';
        $ambildata=DB::table('banksoal')
        ->where('pelajaran_nama',$p_nama)
        ->where('kelas_nama',$k_nama)
        ->where('tapel_nama',$t_nama)
        ->where('materipokok_nama',$mp_nama)
        ->where('kompetensidasar_kode',$kd_kode)
        ->where('kompetensidasar_tipe',$kd_tipe)
        ->orderBy('created_at','desc')
        ->first();

        $output.=$ambildata->pertanyaan."\nA) 123 \nB) aa \nC) cc \nD) vv \nE) zxczc \nANSWER: A";
            //Usage
                // $attemptToWriteObject = User::where('is_active', 0)->get();

                Storage::put('attempt1.txt', $output);
        dd($request);
    }

    public function generatexml2(Request $request){
    //     $pages='';
    //     return view('admin.banksoal.xml_ready_img_normal',compact('pages'
    // ));
    return response()->view('admin.banksoal.xml_ready_img_normal')->header('Content-Type', 'text/xml');
    }

    public function generatexml_do(Request $request){
        // dd($request);
            $p_nama=base64_decode($request->pelajaran_nama);
            $k_nama=base64_decode($request->kelas_nama);
            $t_nama=base64_decode($request->tapel_nama);
            $mp_nama=base64_decode($request->materipokok_nama);
            $kd_kode=base64_decode($request->kompetensidasar_kode);
            $kd_tipe=base64_decode($request->kompetensidasar_tipe);

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        // dd($request);
        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('banksoal')
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->where('materipokok_nama',$mp_nama)
                ->where('kompetensidasar_kode',$kd_kode)
                ->where('kompetensidasar_tipe',$kd_tipe)
                ->skip(0)->take($request->jumlahsoal)
                ->inRandomOrder()
                // ->where('kode',1)
                // ->orWhere('pelajaran_nama',$p_nama)
                // ->where('kelas_nama',$k_nama)
                // ->where('tapel_nama',$t_nama)
                // ->where('kode',2)
                // ->orderBy('created_at','desc')
        ->get();

        $kodegenerate=Uuid::uuid4()->getHex();

//     return response()->view('admin.banksoal.xml',compact(
//     'datas'
// ))->header('Content-Type', 'text/xml');
    return response()->view('admin.banksoal.xml',compact(
    'datas'
))->header('Content-Type', 'application/xml; charset=utf-8')
->header('Content-Type', 'application/force-download')
->header('Content-Type', 'application/download')
->header('Content-Description', 'File Transfer')
->header('Content-Disposition', 'attachment; filename="banksoal-'.$kodegenerate.'.xml"')
->header('Expires', '0')
->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
->header('Pragma', 'public');
    }

    public function generatexml(Request $request){
        // dd($request);
            $p_nama=base64_decode($request->pelajaran_nama);
            $k_nama=base64_decode($request->kelas_nama);
            $t_nama=base64_decode($request->tapel_nama);
            $mp_nama=base64_decode($request->materipokok_nama);
            $kd_kode=base64_decode($request->kompetensidasar_kode);
            $kd_tipe=base64_decode($request->kompetensidasar_tipe);

        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }


        #WAJIB
        $pages='banksoal';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('banksoal')
                ->where('pelajaran_nama',$p_nama)
                ->where('kelas_nama',$k_nama)
                ->where('tapel_nama',$t_nama)
                ->where('materipokok_nama',$mp_nama)
                ->where('kompetensidasar_kode',$kd_kode)
                ->where('kompetensidasar_tipe',$kd_tipe)
                // ->where('kode',1)
                // ->orWhere('pelajaran_nama',$p_nama)
                // ->where('kelas_nama',$k_nama)
                // ->where('tapel_nama',$t_nama)
                // ->where('kode',2)
                ->orderBy('created_at','desc')
        ->get();

        // $datas=$datastanpauniq->unique('kode');





        // 1. ambil datas dari tabel kompetensi dasar where tapel kelas dan pelajarannama
        // 1. ambil last id (Fungsi generatekompetesiid)

            // dd($request);
        return view('admin.banksoal.xml',compact('pages','datas','request','pelajaran_nama','kelas_nama','tapel_nama'
        ,'materipokok_nama'
        ,'kompetensidasar_kode'
        ,'kompetensidasar_tipe'
    ));
    }
}
