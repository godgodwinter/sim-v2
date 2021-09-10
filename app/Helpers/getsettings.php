<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class getsettings {
    
    public static function tahunaktif($datas) {
        $strex=explode("/",$datas);
        // dd($strex);
        $hasil='null';
        if(isset($strex[0])){
            $hasil=$strex[0];
    }
    
    
    return (isset($hasil) ? $hasil : '');
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
    public static function semesteraktif(){
	
        $settings = DB::table('settings')->first();
        $data=$settings->semesteraktif;
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

}