<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pembayaran extends Model
{
        public $table = "pembayaran";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'siswa_id',
            'nominal',
            'nomerinduk',
            'tagihandetail_id',
        ];
        // public function guru()
        // {
        //     return $this->belongsTo('App\Models\guru');
        // }
}
