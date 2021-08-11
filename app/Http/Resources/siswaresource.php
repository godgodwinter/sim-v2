<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class siswaresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $datausers = DB::table('users')->where('nomerinduk',$request->nis)->get();
        // foreach($datausers as $d){
        //     $emailku=$d->id;
        // }

        return[
            'id'=>$this->id,
            'nama'=>$this->nama,
            'nis'=>$this->nis,
            'agama'=>$this->agama,
            'tempatlahir'=>$this->tempatlahir,
            'tgllahir'=>$this->tgllahir,
            'alamat'=>$this->alamat,
            'tapel_nama'=>$this->tapel_nama,
            'kelas_nama'=>$this->kelas_nama,
            'jk'=>$this->jk,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'email'=>$this->email,
            'moodleuser'=>$this->moodleuser,
            'moodlepass'=>$this->moodlepass,
            // 'email'=>$this->email,
            // 'publish'=>Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
