<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tagihan extends Model
{
        public $table = "tagihan";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'tingkatan',
            'jurusan',
            'semester',
            'tipe',
            'bln_awal',
            'bln_akhir',
            'tagihan',
            'total',
        ];
        // public function guru()
        // {
        //     return $this->belongsTo('App\Models\guru');
        // }
}
