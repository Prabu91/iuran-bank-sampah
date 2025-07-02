<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal' => 'date',
    ];


    protected $fillable = [
        'unit_id',
        'nama_penyetor',
        'type',
        'sampah',
        'tanggal',
        'jumlah_kg',
        'nominal',
        'keterangan',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
