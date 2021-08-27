<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemasukan extends Model
{
    public $table = "pemasukan";

    use HasFactory;

    protected $fillable = [
        'nama',
        'nominal',
        'kategori_id',
        'kategori_nama',
        'catatan',
        'tglbayar',
    ];
}
