<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //public function penerapan inheritance //kontroller mewarisi pada turunanya
    public function successResponse($result, $message){
       
        $response=[
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

       return response()->json($response,200);
    }

    public function checkauth($menu){
	
        if(Auth::user()->tipeuser===$menu){
            return 'success';
        }else{    
            return '404';
        }
     
    }
    public function rupiah($angka){
	
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    public function paginationjml(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->paginationjml;
        return $data;
     
    }

    public function sekolahnama(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->sekolahnama;
        return $data;
     
    }

    public function sekolahalamat(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->sekolahalamat;
        return $data;
     
    }

    public function sekolahtelp(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->sekolahtelp;
        return $data;
     
    }

    public function aplikasijudul(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->aplikasijudul;
        return $data;
     
    }

    public function tapelaktif(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->tapelaktif;
        return $data;
     
    }

    public function aplikasijudulsingkat(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->aplikasijudulsingkat;
        return $data;
     
    }
    public function nominaltagihandefault(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->nominaltagihandefault;
        return $data;
     
    }

    public function passdefaultsiswa(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultsiswa;
        return $data;
     
    }
    public function passdefaultortu(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultortu;
        return $data;
     
    }
    public function passdefaultpegawai(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->passdefaultpegawai;
        return $data;
     
    }

    //untuk kenaikan kelas
    public function naik_k($str)
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
    public function naik_k_tanpa_alumni($str)
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
    public function naik_t($str)
        {
            $strex=explode("/",$str);
            $strex[0]=$strex[0]+1;
            $strex[1]=$strex[1]+1;

            $str=implode("/",$strex);
            
            return $str;
        }

    // fungsi dari sisfokol
    //untuk mencegah si jahil #1
    public function cegah($str)
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
        public function cegah2($str)
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
        public function balikin($str)
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
        public function balikin2($str)
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
    //gunakan  return $this->errorResponse('Validation Error',$validator->errors());
}
