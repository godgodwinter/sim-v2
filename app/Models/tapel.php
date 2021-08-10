<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tapel extends Model
{
        public $table = "tapel";

        use HasFactory;
    
        protected $fillable = [
            'nama'
        ];
}
