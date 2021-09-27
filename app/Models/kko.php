<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kko extends Model
{
    public $table = "kko";

    use HasFactory;

    protected $fillable = [
        'nama',
        'tipe',
        'keterangan'
    ];
}
