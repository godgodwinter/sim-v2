<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    public $table = "absensi";

    use HasFactory;

    protected $fillable = [
        'siswa_nama',
        'siswa_nis',
        'kelas_nama',
        'tapel_nama',
        'tanggal_masuk',
        'ket',
        'guru_nomerinduk',
        'guru_nama'
    ];
}
