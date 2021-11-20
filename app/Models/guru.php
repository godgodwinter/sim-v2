<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class guru extends Model
{
        public $table = "guru";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'nama',
            'jabatan',
            'alamat',
            'telp',
            'jk',
            'golongan',
            'pendidikanterakhir',
            'kategori_id',
            'users_id',
        ];

        public function kategori()
        {
            return $this->belongsTo('App\Models\kategori');
        }
        public function users()
        {
            return $this->belongsTo('App\Models\User');
        }
        public function dataajar()
        {
            return $this->belongsTo('App\Models\dataajar');
        }

}
