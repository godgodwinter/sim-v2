<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class dataajar extends Model
{
        public $table = "dataajar";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'guru_id',
            'kelas_id',
            'mapel_id',
        ];
        public function guru()
        {
            return $this->belongsTo('App\Models\guru');
        }
        public function kelas()
        {
            return $this->belongsTo('App\Models\kelas');
        }
        public function mapel()
        {
            return $this->belongsTo('App\Models\mapel');
        }
        public function banksoal()
        {
            return $this->hasMany('App\Models\banksoal');
        }
        public function kompetensidasar()
        {
            return $this->hasMany('App\Models\kompetensidasar');
        }
}
