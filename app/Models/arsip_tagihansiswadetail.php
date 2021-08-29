<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arsip_tagihansiswadetail extends Model
{
    public $table = "arsip_tagihansiswadetail";

    use HasFactory;

    protected $fillable = [
        'siswa_nis',
        'siswa_nama',
        'tapel_nama',
        'kelas_nama',
        'nominal',
    ];
}
