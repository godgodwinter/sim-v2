<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagihansiswa extends Model
{
    public $table = "tagihansiswa";

    use HasFactory;

    protected $fillable = [
        'siswa_nis',
        'siswa_nama',
        'kelas_nama',
        'tapel_nama',
        'nominaltagihan',
    ];
}
