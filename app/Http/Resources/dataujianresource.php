<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class dataujianresource extends JsonResource
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
            'Nama kelas'=>$this->kelas != null ? $this->kelas->tingkatan.' '.$this->kelas->jurusan.' '.$this->kelas->suffix : '',
            'nama'=>$this->nama,
            'nomerinduk'=>$this->nomerinduk,
            'moodlepass'=>$this->moodlepass,
        ];
    }
}
