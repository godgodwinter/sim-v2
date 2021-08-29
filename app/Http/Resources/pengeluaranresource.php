<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class pengeluaranresource extends JsonResource
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
            'nominal'=>$this->nominal,
            'kategori_nama'=>$this->kategori_nama,
            'catatan'=>$this->catatan,
            'tglbayar'=>$this->tglbayar,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
