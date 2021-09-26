<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banksoal extends Model
{
    public $table = "banksoal";

    use HasFactory;

    protected $fillable = [
        'pertanyaan',
        'nilai',
        'tingkatkesulitan',
        'tingkatkesulitanangka',
        'kodegenerate',
        'tapel_nama',
        'kelas_nama',
        'pelajaran_nama',
        'materipokok_nama',
        'kompetensidasar_kode',
        'kompetensidasar_tipe',
    ];
}
