<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagihanatur extends Model
{
    public $table = "tagihanatur";

    use HasFactory;

    protected $fillable = [
        'kelas_nama',
        'tapel_nama',
        'nominaltagihan',
        'gambar',
    ];
}
