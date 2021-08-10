<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengeluaran extends Model
{
    public $table = "pengeluaran";

    use HasFactory;

    protected $fillable = [
        'nama',
        'nominal',
        'kategori_id',
        'kategori_nama',
        'catatan',
    ];
}
