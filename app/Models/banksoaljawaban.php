<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class banksoaljawaban extends Model
{
        public $table = "banksoaljawaban";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'jawaban',
            'nilai',
            'gambar',
            'hasil',
            'banksoal_id',
        ];
        public function banksoal()
        {
            return $this->belongsTo('App\Models\banksoal');
        }
}
