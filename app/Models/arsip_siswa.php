<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arsip_siswa extends Model
{
    public $table = "arsip_siswa";

    use HasFactory;

    protected $fillable = [
        'nama',
        'nis',
        'agama',
        'tempatlahir',
        'tgllahir',
        'alamat',
        'kelas_nama',
        'tapel_nama',
        'jk',
        'moodleuser',
        'moodlepass',
    ];
}
