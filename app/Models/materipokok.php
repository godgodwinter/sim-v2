<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materipokok extends Model
{
    public $table = "materipokok";

    use HasFactory;

    protected $fillable = [
        'nama',
        'link',
        'tapel_nama',
        'kelas_nama',
        'pelajaran_nama',
        'kompetensidasar_nama',
        'kompetensidasar_kode',
        'kompetensidasar_tipe',
    ];
}
