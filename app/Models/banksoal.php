<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class banksoal extends Model
{
        public $table = "banksoal";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'pertanyaan',
            'nilai',
            'tingkatkesulitan',
            'tingkatkesulitanangka',
            'gambar',
            'dataajar_id',
        ];
        public function dataajar()
        {
            return $this->belongsTo('App\Models\dataajar');
        }
        public function banksoaljawaban()
        {
            return $this->hasMany('App\Models\banksoaljawaban')->orderBy('id','asc');
            // return $this->hasMany('App\Models\banksoaljawaban')->orderBy('id','desc');
        }
}
