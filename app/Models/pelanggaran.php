<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pelanggaran extends Model
{
        public $table = "pelanggaran";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'ket',
            'skor',
            'tgl',
            'siswa_id',
        ];
        public function siswa()
        {
            return $this->belongsTo('App\Models\siswa');
        }
}
