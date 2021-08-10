<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagihansiswadetail extends Model
{
    public $table = "tagihansiswadetail";

    use HasFactory;

    protected $fillable = [
        'tagihansiswa_id',
        'nominal',
    ];
}
