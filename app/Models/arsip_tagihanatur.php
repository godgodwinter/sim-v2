<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arsip_tagihanatur extends Model
{
    public $table = "arsip_tagihanatur";

    use HasFactory;

    protected $fillable = [
        'kelas_nama',
        'tapel_nama',
        'nominaltagihan',
        'gambar',
    ];
}
