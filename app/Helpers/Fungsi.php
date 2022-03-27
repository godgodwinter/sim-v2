<?php
namespace App\Helpers;

use App\Models\dataajar;
use App\Models\kko;
use App\Models\kompetensidasar;
use App\Models\materipokok;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Fungsi {
    // public static function get_username($user_id) {
    //     $user = DB::table('users')->where('userid', $user_id)->first();
    //     return (isset($user->username) ? $user->username : '');
    // }
    public static function getJawabanSoalTergenerated($id) {
        //inputan generatebanksoal_id
        $jawaban = DB::table('banksoaljawaban')->where('id', $id)->first();
        return $jawaban;
    }

    public static function periksatingkatkesulitan($datas) {
        $strex=explode(" ",$datas);
        // dd(count($strex));
        // $hasil='Tidak diketahui';
        $hasil='Mudah';
        for($i=0;$i<count($strex);$i++){
            $ambilkko=kko::where('nama',$strex[$i])->first();
            if($ambilkko!=null){
                $tipe=$ambilkko->tipe;
                if($tipe=='sulit'){
                    $hasil=$tipe;
                }
                if($hasil!='sulit'){
                    if($tipe=='sedang'){
                        $hasil=$tipe;
                    }
                    //sedang
                        //mudah
                        if($hasil!='sedang'){
                            $hasil=$tipe;
                        }
                }
            }
        }



    return (isset($hasil) ? $hasil : '');
    }

    public static  function ambilkdmateripokok($data,$dataajar_id) {

        $kd_materi=0;
        $kd_kd=0;
        $datamateri=materipokok::with('kompetensidasar')->where('id',$data)->first();
        $hasil=0;
        if($datamateri->kompetensidasar!=null){
            $kd_kd=$datamateri->kompetensidasar->kode;

            if($datamateri->kompetensidasar->tipe==1){
                $tipe=$datamateri->kompetensidasar->tipe;
                $preffix='3.';
            }else{
                $tipe=$datamateri->kompetensidasar->tipe;
                $preffix='4.';
            }
            //ambil kode kompetensidasar
            $datakompetensidasar=kompetensidasar::where('dataajar_id',$dataajar_id)->get();
            // dd($datakompetensidasar,$dataajar_id);
            $collection = new Collection();
            foreach($datakompetensidasar as $datakd){
                $nomer=1;
                $ambildatamateripokok=materipokok::where('kompetensidasar_id',$datakd->id)->get();
                foreach($ambildatamateripokok as $dm){
                    $dm_id=$dm->id;

                    $collection->push((object)[
                        'dm_id' => $dm_id,
                        'kode' => $nomer,
                    ]);
                    $nomer++;
                }
            }
        }
        $kd_materi=$collection->where('dm_id',$data)->first()->kode;
        $hasil=$preffix.$kd_kd.'.'.$kd_materi;
        // dd($hasil,$collection);
        return $hasil;
    }
    public static  function isWeekend($date) {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 6 );
    }

    public static function periksaabc($data){
        $hasil='A';
        if($data=='1'){
            $hasil='A';
        }elseif($data=='2'){
            $hasil='B';
        }elseif($data=='3'){
            $hasil='C';
        }elseif($data=='4'){
            $hasil='D';
        }else{
            $hasil='E';
        }
        // dd($data,$hasil);
        return $hasil;
    }

    public static function tanggalgaringcreated($data){
        $data2=explode(" ",$data);

        $inputan=$data2[0];
        $bulanindo='Januari';
        $str=explode("-",$inputan);
        return $str[2]."/".$str[1]."/".$str[0];
    }
    public static function tanggalgaring($inputan){
        $bulanindo='Januari';
        $str=explode("-",$inputan);
        return $str[2]."/".$str[1]."/".$str[0];
    }

    public static function tanggalindocreated($data){
        $data2=explode(" ",$data);

        $inputan=$data2[0];

        $bulanindo='Januari';
        $str=explode("-",$inputan);
                if($str[1]=='01'){
                    $bulanindo='Januari';
                }elseif($str[1]=='02'){
                    $bulanindo='Februari';
                }elseif($str[1]=='03'){
                    $bulanindo='Maret';
                }elseif($str[1]=='04'){
                    $bulanindo='April';
                }elseif($str[1]=='05'){
                    $bulanindo='Mei';
                }elseif($str[1]=='06'){
                    $bulanindo='Juni';
                }elseif($str[1]=='07'){
                    $bulanindo='Juli';
                }elseif($str[1]=='08'){
                    $bulanindo='Agustus';
                }elseif($str[1]=='09'){
                    $bulanindo='September';
                }elseif($str[1]=='10'){
                    $bulanindo='Oktober';
                }elseif($str[1]=='11'){
                    $bulanindo='November';
                }else{
                    $bulanindo='Desember';
                }

        return $str[2]." ".$bulanindo." " .$str[0];
    }
    public static function tanggalindobln($inputan){
        $bulanindo='Januari';
        $str=explode("-",$inputan);
                if($str[1]=='01'){
                    $bulanindo='Januari';
                }elseif($str[1]=='02'){
                    $bulanindo='Februari';
                }elseif($str[1]=='03'){
                    $bulanindo='Maret';
                }elseif($str[1]=='04'){
                    $bulanindo='April';
                }elseif($str[1]=='05'){
                    $bulanindo='Mei';
                }elseif($str[1]=='06'){
                    $bulanindo='Juni';
                }elseif($str[1]=='07'){
                    $bulanindo='Juli';
                }elseif($str[1]=='08'){
                    $bulanindo='Agustus';
                }elseif($str[1]=='09'){
                    $bulanindo='September';
                }elseif($str[1]=='10'){
                    $bulanindo='Oktober';
                }elseif($str[1]=='11'){
                    $bulanindo='November';
                }else{
                    $bulanindo='Desember';
                }

        return $bulanindo." " .$str[0];
    }
    public static function tanggalindo($inputan){
        $bulanindo='Januari';
        $str=explode("-",$inputan);
                if($str[1]=='01'){
                    $bulanindo='Januari';
                }elseif($str[1]=='02'){
                    $bulanindo='Februari';
                }elseif($str[1]=='03'){
                    $bulanindo='Maret';
                }elseif($str[1]=='04'){
                    $bulanindo='April';
                }elseif($str[1]=='05'){
                    $bulanindo='Mei';
                }elseif($str[1]=='06'){
                    $bulanindo='Juni';
                }elseif($str[1]=='07'){
                    $bulanindo='Juli';
                }elseif($str[1]=='08'){
                    $bulanindo='Agustus';
                }elseif($str[1]=='09'){
                    $bulanindo='September';
                }elseif($str[1]=='10'){
                    $bulanindo='Oktober';
                }elseif($str[1]=='11'){
                    $bulanindo='November';
                }else{
                    $bulanindo='Desember';
                }

        return $str[2]." ".$bulanindo." " .$str[0];
    }
    public static function manipulasiTanggal($tgl,$jumlah=1,$format='days'){
        $currentDate = $tgl;
        return date('Y-m-d', strtotime($jumlah.' '.$format, strtotime($currentDate)));
    }

    public static function kompetensidasargeneratekode($dataajar,$tipe='1'){
        $id=0;
        // $datas=Fungsi::periksakompetensidasar($id);

        $datas=DB::table('kompetensidasar')
        ->where('kode',$id)
        ->where('dataajar_id',$dataajar->id)
        ->where('tipe',$tipe)
        ->count();
        // dd($id,$datas,$tapel_nama,$kelas_nama,$pelajaran_nama);

        do {
        $id++;

            $datas=DB::table('kompetensidasar')
            ->where('kode',$id)
            ->where('dataajar_id',$dataajar->id)
            ->where('tipe',$tipe)
            ->count();
            // dd($id,$datas,$tapel_nama,$kelas_nama,$pelajaran_nama);
        }
        while ($datas>0);
        // dd($id,$datas,$tapel_nama,$kelas_nama,$pelajaran_nama);
        // dd($id,$datas,$tapel_nama,$kelas_nama,$pelajaran_nama);

        return $id;
    }
    // public static function periksakompetensidasar($id){


    //     $datas=DB::table('kompetensidasar')
    //     ->where('kode',$id)
    //     ->count();

    //     if($datas>0){
    //         $id++;
    //         $datas=Fungsi::periksakompetensidasar($id);

    //     }

    //     return $id;
    // }

    public static function predikat($angka){
        if($angka>=90){
            $hasil='A';
        }elseif(($angka<90)&&($angka>=85)){
            $hasil='A-';
        }elseif(($angka<85)&&($angka>=80)){
            $hasil='B+';
        }elseif(($angka<80)&&($angka>=75)){
            $hasil='B-';
        }elseif(($angka<75)&&($angka>=70)){
            $hasil='C+';
        }elseif(($angka<70)&&($angka>=65)){
            $hasil='C-';
        }elseif($angka<65){
            $hasil='D';
        }
        return $hasil;
    }

    public static function periksasemester($datas) {
        $strex=explode(" ",$datas);
        // dd($strex);
    if(isset($datas)){
            $hasil='null';
        $cekambilkode = DB::table('kategori')->where('nama',$datas)->where('prefix','semester')->count();
        if($cekambilkode>0){
        $ambilkode = DB::table('kategori')->where('nama',$datas)->where('prefix','semester')->first();
        $hasil=$ambilkode->kode;
        }
        return $hasil;
    }

    return (isset($hasil) ? $hasil : '');
}

    public static function periksajurusan($datas) {
            $strex=explode(" ",$datas);
            // dd($strex);
        if(isset($strex[1])){
            if($strex[1]=='OTO'){
                $hasil='Teknik Otomotif';
            }elseif($strex[1]=='TKJ'){
                $hasil='Teknik Komputer dan Jaringan';
            }else{
                $hasil='Umum';
            }
        }

        return (isset($hasil) ? $hasil : '');
    }

    public static function periksajurusankompetensi($datas) {
        $strex=explode(" ",$datas);
        // dd($strex);
    if(isset($strex[1])){
        if($strex[1]=='OTO'){
            $hasil='Teknik dan Bisnis Sepeda Motor';
        }elseif($strex[1]=='TKJ'){
            $hasil='Teknik Komputer dan Jaringan';
        }else{
            $hasil='Umum';
        }
    }

    return (isset($hasil) ? $hasil : '');
}
    public static function periksajurusankode($datas) {
        $strex=explode(" ",$datas);
        // dd($strex);
        $hasil='null';
        if(isset($strex[1])){
        if($strex[1]=='OTO'){
            $hasil=$strex[1];
        }elseif($strex[1]=='TKJ'){
            $hasil=$strex[1];
        }else{
            $hasil='Umum';
        }
    }

    return (isset($hasil) ? $hasil : '');
    }

    public static function periksajurusantingkat($datas) {
        $strex=explode(" ",$datas);
        // dd($strex);
        $hasil='null';
        if(isset($strex[0])){
            $hasil=$strex[0];
    }


    return (isset($hasil) ? $hasil : '');
    }

    public static function tahunaktif($datas) {
        $strex=explode("/",$datas);
        // dd($strex);
        $hasil='null';
        if(isset($strex[0])){
            $hasil=$strex[0];
    }


    return (isset($hasil) ? $hasil : '');
    }


    public static function checkauth($menu){

        if(Auth::user()->tipeuser===$menu){
            return 'success';
        }else{
            return '404';
        }

    }
    public static function toangka($angka){
        $hasil = preg_replace("/[^0-9]/", "", $angka);
        return $hasil;

    }
    public static function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;

    }

    public static function paginationjml(){

        $settings = DB::table('settings')->first();
        $data=$settings->paginationjml;
        return $data;

    }

    public static function app_nama(){

        $settings = DB::table('settings')->first();
        $data=$settings->app_nama;
        return $data;

    }

    public static function app_namapendek(){

        $settings = DB::table('settings')->first();
        $data=$settings->app_namapendek;
        return $data;

    }
    public static function lembaga_nama(){

        $settings = DB::table('settings')->first();
        $data=$settings->lembaga_nama;
        return $data;
    }
    public static function lembaga_jalan(){

        $settings = DB::table('settings')->first();
        $data=$settings->lembaga_jalan;
        return $data;
    }
    public static function lembaga_telp(){

        $settings = DB::table('settings')->first();
        $data=$settings->lembaga_telp;
        return $data;
    }
    public static function lembaga_kota(){

        $settings = DB::table('settings')->first();
        $data=$settings->lembaga_kota;
        return $data;
    }


    public static function tapelaktif(){

        $settings = DB::table('settings')->first();
        $data=$settings->tapelaktif;
        return $data;

    }
    public static function semesteraktif(){

        $settings = DB::table('settings')->first();
        $data=$settings->semesteraktif;
        return $data;

    }

    public static function nominaltagihandefault(){

        $settings = DB::table('settings')->first();
        $data=$settings->nominaltagihandefault;
        return $data;

    }

    public static function passdefaultsiswa(){

        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultsiswa;
        return $data;

    }
    public static function passdefaultortu(){

        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultortu;
        return $data;

    }
    public static function passdefaultpegawai(){

        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultpegawai;
        return $data;

    }
    public static function sekolahlogo(){

        $settings = DB::table('settings')->first();
        $data=$settings->sekolahlogo;

        return $data;

    }
    public static function sekolahttd(){

        $settings = DB::table('settings')->first();
        $data=$settings->sekolahttd;
        return $data;

    }
    public static function sekolahttd2(){

        $settings = DB::table('settings')->first();
        $data=$settings->sekolahttd2;
        return $data;

    }
    public static function minimalpembayaranujian(){

        $settings = DB::table('settings')->first();
        $data=$settings->minimalpembayaranujian;
        return $data;

    }

    //untuk kenaikan kelas
    public static  function naik_k($str)
        {
                //  $stre=str_replace('X','Xzz',$str);
                //  $str=substr($stre,1);

            $strex=explode(" ",$str);
            if($strex[0]==="X"){
                $strex[0]="XI";
            }else if($strex[0]==="XI"){
                $strex[0]="XII";
            }else if($strex[0]==="XII"){
                $strex[0]="Alumni";
            }


            $str=implode(" ",$strex);

            return $str;
        }

    //untuk kenaikan kelas
    public static function naik_k_tanpa_alumni($str)
    {
        $strex=explode(" ",$str);
        if($strex[0]==="X"){
            $strex[0]="XI";
        }else if($strex[0]==="XI"){
            $strex[0]="XII";
        }


        $str=implode(" ",$strex);

        return $str;
    }
    //naik tapel
    public static function naik_t($str)
        {
            $strex=explode("/",$str);
            $strex[0]=$strex[0]+1;
            $strex[1]=$strex[1]+1;

            $str=implode("/",$strex);

            return $str;
        }

    // fungsi dari sisfokol
    //untuk mencegah si jahil #1
    public static function cegah($str)
        {
            $str = trim(htmlentities(htmlspecialchars($str)));
        $search = array ("'\''",
                            "'%'",
                            "'@'",
                            "'_'",
                            "'1=1'",
                            "'/'",
                            "'!'",
                            "'<'",
                            "'>'",
                            "'\('",
                            "'\)'",
                            "';'",
                            "'-'",
                            "'_'");

        $replace = array ("xpsijix",
                            "xpersenx",
                            "xtkeongx",
                            "xgwahx",
                            "x1smdgan1x",
                            "xgmringx",
                            "xpentungx",
                            "xkkirix",
                            "xkkananx",
                            "xkkurix",
                            "xkkurnanx",
                            "xkommax",
                            "xstrix",
                            "xstripbwhx");

        $str = preg_replace($search,$replace,$str);
        return $str;
        }



        //untuk mencegah si jahil #2
        public static function cegah2($str)
        {
            $str = trim($str);
        $search = array ("'\''",
                            "'%'",
                            "'@'",
                            "'_'",
                            "'1=1'",
                            "'/'",
                            "'!'",
                            "'<'",
                            "'>'",
                            "'\('",
                            "'\)'",
                            "';'",
                            "'-'",
                            "'_'");

        $replace = array ("xpsijix",
                            "xpersenx",
                            "xtkeongx",
                            "xgwahx",
                            "x1smdgan1x",
                            "xgmringx",
                            "xpentungx",
                            "xkkirix",
                            "xkkananx",
                            "xkkurix",
                            "xkkurnanx",
                            "xkommax",
                            "xstrix",
                            "xstripbwhx");

        $str = preg_replace($search,$replace,$str);
        return $str;
        }

        //balikino. . o . . .. o. . .. . balikin
        public static function balikin($str)
        {
        $search = array ("'xpsijix'",
                            "'xpersenx'",
                            "'xtkeongx'",
                            "'xgwahx'",
                            "'x1smdgan1x'",
                            "'xgmringx'",
                            "'xpentungx'",
                            "'xkkirix'",
                            "'xkkananx'",
                            "'xkkurix'",
                            "'xkkurnanx'",
                            "'xkommax'",
                            "'xstrix'",
                            "'xstripbwhx'");

        $replace = array ("'",
                            "%",
                            "@",
                            "_",
                            "1=1",
                            "/",
                            "!",
                            "<",
                            ">",
                            "(",
                            ")",
                            ";",
                            "-",
                            "_");

        $str = preg_replace($search,$replace,$str);

        return $str;
        }



        //balikin2
        public static function balikin2($str)
        {
        $search = array ("'xpsijix'",
                            "'xpersenx'",
                            "'xtkeongx'",
                            "'xgwahx'",
                            "'x1smdgan1x'",
                            "'xgmringx'",
                            "'xpentungx'",
                            "'xkkirix'",
                            "'xkkananx'",
                            "'xkkurix'",
                            "'xkkurnanx'",
                            "'xkommax'",
                            "'xstrix'",
                            "'xstripbwhx'");

        $replace = array ("'",
                            "%",
                            "@",
                            "_",
                            "1=1",
                            "/",
                            "!",
                            "<",
                            ">",
                            "(",
                            ")",
                            ";",
                            "-",
                            "_");

        $str = preg_replace($search,$replace,$str);
        return $str;
        }

}
