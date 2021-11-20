<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kompetensidasar extends Model
{
        public $table = "kompetensidasar";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'kode',
            'tipe',
            'dataajar_id',
        ];
        public function materipokok()
        {
            return $this->hasMany('App\Models\materipokok');
        }
        public function dataajar()
        {
            return $this->belongsTo('App\Models\dataajar');
        }
        public function inputnilai(){
            return $this->hasMany('App\Models\inputnilai');
        }
}
