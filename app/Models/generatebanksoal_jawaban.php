<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class generatebanksoal_jawaban extends Model
{
        public $table = "generatebanksoal_jawaban";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'banksoaljawaban_id',
            'pilihan',
            'benarsalah',
            'generatebanksoal_detail_id',
            'generatebanksoal_id',
        ];
        public function banksoaljawaban()
        {
            return $this->belongsTo('App\Models\banksoaljawaban');
        }
}
