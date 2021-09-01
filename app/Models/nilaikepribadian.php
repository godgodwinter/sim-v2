<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaikepribadian extends Model
{
    public $table = "nilaikepribadian";

    use HasFactory;

    protected $fillable = [
        'siswa_nis',
        'siswa_nama',
        'tapel_nama',
        'kelas_nama',
        'guru_nomerinduk',
        'guru_nama',
        'kepribadian_nama',
        'nilai',
    ];
}
