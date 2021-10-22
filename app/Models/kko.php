<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kko extends Model
{
        public $table = "kko";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'tipe',
            'keterangan',
        ];


}
