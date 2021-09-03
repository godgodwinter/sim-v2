<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class Fungsi {
    // public static function get_username($user_id) {
    //     $user = DB::table('users')->where('userid', $user_id)->first();
    //     return (isset($user->username) ? $user->username : '');
    // }
    public static function periksajurusan($datas) {
            $strex=explode(" ",$datas);
            // dd($strex);
            if($strex[1]=='OTO'){
                $hasil='Otomotif';
            }elseif($strex[1]=='TKJ'){
                $hasil='Teknik Komputer dan Jaringan';
            }else{
                $hasil='Umum';
            }
        
        return (isset($hasil) ? $hasil : '');
    }

    public static function periksajurusankode($datas) {
        $strex=explode(" ",$datas);
        // dd($strex);
        if($strex[1]=='OTO'){
            $hasil=$strex[1];
        }elseif($strex[1]=='TKJ'){
            $hasil=$strex[1];
        }else{
            $hasil='Umum';
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
    public static function rupiah($angka){
	
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    public static function paginationjml(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->paginationjml;
        return $data;
     
    }

    public static function sekolahnama(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->sekolahnama;
        return $data;
     
    }

    public static function sekolahalamat(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->sekolahalamat;
        return $data;
     
    }

    public static function sekolahtelp(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->sekolahtelp;
        return $data;
     
    }

    public static function aplikasijudul(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->aplikasijudul;
        return $data;
     
    }

    public static function tapelaktif(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->tapelaktif;
        return $data;
     
    }

    public static function aplikasijudulsingkat(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->aplikasijudulsingkat;
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