<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class generatebanksoal_detail extends Model
{
        public $table = "generatebanksoal_detail";

        use SoftDeletes;
        use HasFactory;

        protected $fillable = [
            'generatebanksoal_id',
            'banksoal_id',
        ];
        public function dataajar()
        {
            return $this->belongsTo('App\Models\dataajar');
        }
}
