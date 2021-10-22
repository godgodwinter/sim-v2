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
    //gunakan  return $this->errorResponse('Validation Error',$validator->errors());
}
