<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mapel extends Model
{
        public $table = "mapel";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'jurusan',
            'kkm',
            'tapel_id',
            'kelas_id',
            'semester_nama',
        ];

        public function tapel()
        {
            return $this->belongsTo('App\Models\tapel');
        }

        public function kelas()
        {
            return $this->belongsTo('App\Models\kelas');
        }

}
