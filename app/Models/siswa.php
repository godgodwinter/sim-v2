<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    public $table = "siswa";

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
