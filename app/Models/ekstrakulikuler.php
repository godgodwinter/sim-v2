<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ekstrakulikuler extends Model
{
    public $table = "ekstrakulikuler";

    use HasFactory;

    protected $fillable = [
        'nama',
        'tapel_nama',
    ];
}
