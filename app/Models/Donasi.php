<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peserta',
        'unit_id',
        'jumlah_donasi',
        'bukti_tf',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
