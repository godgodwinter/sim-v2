<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggaran extends Model
{
    public $table = "pelanggaran";

    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'pelanggaran_id',
        'tgl',
    ];

    public function siswa()
    {
        return $this->belongsTo('App\Models\siswa');
    }

    public function pelanggaran()
    {
        return $this->belongsTo('App\Models\pelanggaran');
    }
}
