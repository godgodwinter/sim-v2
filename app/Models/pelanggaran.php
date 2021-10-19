<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggaran extends Model
{
    public $table = "pelanggaran";

    use HasFactory;

    protected $fillable = [
        'nama',
        'point',
    ];
}
