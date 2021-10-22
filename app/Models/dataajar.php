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
}
