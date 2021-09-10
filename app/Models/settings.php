<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    public $table = "settings";

    use HasFactory;

    protected $fillable = [
        'paginationjml',
        'tapelaktif',
        'sekolahnama',
        'sekolahalamat',
        'sekolahtelp',
        'aplikasijudul',
        'aplikasijudulsingkat',
        'nominaltagihandefault',
        'passdefaultsiswa',
        'passdefaultpegawai',
        'passdefaultortu',
        'sekolahlogo',
        'sekolahttd',
        'sekolahttd2',
        'minimalpembayaranujian',
        'semesterakatif',
    ];
}
