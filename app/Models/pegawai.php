<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    public $table = "pegawai";

    use HasFactory;

    protected $fillable = [
        'nama',
        'nig',
        'kategori_nama',
        'alamat',
        'telp',
    ];
}
