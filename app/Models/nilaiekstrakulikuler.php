<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiekstrakulikuler extends Model
{
    public $table = "nilaiekstrakulikuler";

    use HasFactory;

    protected $fillable = [
        'siswa_nis',
        'siswa_nama',
        'tapel_nama',
        'kelas_nama',
        'guru_nomerinduk',
        'guru_nama',
        'ekstrakulikuler_nama',
        'nilai',
    ];
}
