<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ekskuldetail extends Model
{
        public $table = "ekskuldetail";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'siswa_id',
            'nilai',
            'ekskul_id',
        ];
        public function ekskul()
        {
            return $this->belongsTo('App\Models\ekskul');
        }
        public function siswa()
        {
            return $this->belongsTo('App\Models\siswa');
        }
}
