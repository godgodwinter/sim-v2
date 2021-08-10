<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    public $table = "kelas";

    use HasFactory;

    protected $fillable = [
        'nama'
    ];
}
