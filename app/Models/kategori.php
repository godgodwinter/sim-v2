<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    public $table = "kategori";

    use HasFactory;

    protected $fillable = [
        'nama',
        'prefix',
    ];
}
