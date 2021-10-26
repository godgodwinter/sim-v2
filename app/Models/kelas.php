<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kelas extends Model
{
        public $table = "kelas";

        use HasFactory;

        protected $fillable = [
            'tingkatan',
            'jurusan',
            'suffix',
            'guru_id',
        ];

        public function guru()
        {
            return $this->belongsTo('App\Models\guru');
        }
        public function siswa()
        {
            return $this->hasMany('App\Models\siswa');
        }

}
