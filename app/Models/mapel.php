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
            'tipe',
            'kkm',
            'tingkatan',
            'jurusan',
            'semester',
            'tapel_id',
        ];

}
