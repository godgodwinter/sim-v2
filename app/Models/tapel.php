<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tapel extends Model
{
        public $table = "tapel";

        use HasFactory;

        protected $fillable = [
            'nama',
        ];

}
