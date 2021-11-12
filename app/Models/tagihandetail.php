<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tagihandetail extends Model
{
        public $table = "tagihandetail";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'kelas_id',
            'tagihan_id',
        ];
        // public function guru()
        // {
        //     return $this->belongsTo('App\Models\guru');
        // }
}
