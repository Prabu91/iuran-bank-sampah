<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitWallet extends Model
{
    use HasFactory;

    protected $table = 'unit_wallets';

    protected $fillable = [
        'unit_id',
        'balance',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
