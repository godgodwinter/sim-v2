<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class materipokok extends Model
{
        public $table = "materipokok";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'link',
            'kompetensidasar_id',
        ];
        public function kompetensidasar()
        {
            return $this->belongsTo('App\Models\kompetensidasar');
        }
        public function inputnilai()
        {
            return $this->hasMany('App\Models\inputnilai');
        }
}
