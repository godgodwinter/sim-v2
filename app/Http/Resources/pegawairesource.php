<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class pegawairesource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'nama'=>$this->nama,
            'nig'=>$this->nig,
            'kategori_nama'=>$this->kategori_nama,
            'alamat'=>$this->alamat,
            'telp'=>$this->telp,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'email'=>$this->email,
            // 'email'=>$this->email,
            // 'publish'=>Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
