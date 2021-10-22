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
            'nama',
            'guru_id',
        ];

        public function guru()
        {
            return $this->belongsTo('App\Models\guru');
        }

}
