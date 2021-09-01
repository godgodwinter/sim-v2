<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kepribadian extends Model
{
    public $table = "kepribadian";

    use HasFactory;

    protected $fillable = [
        'nama',
        'tapel_nama',
    ];
}
