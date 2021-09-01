<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guru extends Model
{
    public $table = "guru";

    use HasFactory;

    protected $fillable = [
        'nama',
        'nomerinduk',
        'kategori_nama',
        'alamat',
        'telp',
        'jk',
        'golongan',
        'pendidikanterakhir'
    ];
}
