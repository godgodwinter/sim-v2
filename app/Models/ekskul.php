<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ekskul extends Model
{
        public $table = "ekskul";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'singkatan',
            'guru_id',
        ];
        public function guru()
        {
            return $this->belongsTo('App\Models\guru');
        }
}
