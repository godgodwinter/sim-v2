<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kompetensidasar extends Model
{
    public $table = "kompetensidasar";

    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'tipe',
        'tapel_nama',
        'kelas_nama',
        'pelajaran_nama',
    ];
}
