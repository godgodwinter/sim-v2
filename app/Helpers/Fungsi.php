<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
 
class Fungsi {
    // public static function get_username($user_id) {
    //     $user = DB::table('users')->where('userid', $user_id)->first();
    //     return (isset($user->username) ? $user->username : '');
    // }
    public static function periksajurusan($datas) {
            $strex=explode(" ",$datas);
            dd($strex);
            if($strex[1]=='OTO'){
                $hasil='Otomotof';
            }elseif($strex[1]=='TKJ'){
                $hasil='Teknik Komputer dan Jaringan';
            }else{
                $hasil='Umum';
            }
        
        return (isset($hasil) ? $hasil : '');
    }
}