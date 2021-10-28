<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class generatebanksoal extends Model
{
        public $table = "generatebanksoal";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'jml',
            'soal',
            'jawaban',
            'mudah',
            'sedang',
            'sulit',
            'tgl',
            'dataajar_id',
        ];
        public function dataajar()
        {
            return $this->belongsTo('App\Models\dataajar');
        }
}
