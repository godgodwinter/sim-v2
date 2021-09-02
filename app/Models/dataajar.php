<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataajar extends Model
{
    public $table = "dataajar";

    use HasFactory;

    protected $fillable = [
        'pelajaran_nama',
        'tipepelajaran',
        'jurusan',
        'pelajaran_kelas_nama',
        'kelas_nama',
        'guru_nis',
        'guru_nama',
    ];
}
