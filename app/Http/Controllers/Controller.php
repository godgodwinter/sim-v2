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
    //gunakan  return $this->errorResponse('Validation Error',$validator->errors());
}
