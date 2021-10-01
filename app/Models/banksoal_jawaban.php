<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banksoal_jawaban extends Model
{
    public $table = "banksoal_jawaban";

    use HasFactory;

    protected $fillable = [
        'jawaban',
        'nilai',
        'kodegenerate',
        'kategorisoal_nama',
    ];
}
