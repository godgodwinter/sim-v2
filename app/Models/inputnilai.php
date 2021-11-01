<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inputnilai extends Model
{
        public $table = "inputnilai";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nilai',
            'status',
            'siswa_id',
            'materipokok_id',
        ];

        public function siswa()
        {
            return $this->belongsTo('App\Models\siswa');
        }

        public function materipokok()
        {
            return $this->belongsTo('App\Models\materipokok');
        }


}
