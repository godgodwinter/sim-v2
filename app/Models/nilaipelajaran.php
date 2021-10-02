<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaipelajaran extends Model
{
    public $table = "nilaipelajaran";

    use HasFactory;

    protected $fillable = [
        'siswa_nis',
        'siswa_nama',
        'tapel_nama',
        'kelas_nama',
        'guru_nomerinduk',
        'guru_nama',
        'jenisnilai_nama',
        'pelajaran_nama',
        'nilai',
        'materipokok_nama',
        'kompetensidasar_kode',
        'kompetensidasar_tipe',
    ];
}
