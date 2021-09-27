<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class kkoresource extends JsonResource
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
            'tipe'=>$this->tipe,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
