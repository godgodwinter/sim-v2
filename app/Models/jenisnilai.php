<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisnilai extends Model
{
    public $table = "jenisnilai";

    use HasFactory;

    protected $fillable = [
        'nama',
        'tapel_nama',
        'kode',
        'tipe',
        'semester_nama',
    ];
}
