<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'noka',
        'no_hp',
        'alamat',
        'kecamatan',
        'bln_menunggak',
        'total_tagihan',
    ];
}
