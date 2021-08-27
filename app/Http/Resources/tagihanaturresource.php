<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class tagihanaturresource extends JsonResource
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
            'kelas_nama'=>$this->kelas_nama,
            'tapel_nama'=>$this->tapel_nama,
            'nominaltagihan'=>$this->nominaltagihan,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            // 'email'=>$this->email,
            // 'publish'=>Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
