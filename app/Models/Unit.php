<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';

    protected $fillable = [
        'unit_name',
        'pic_name',
        'address',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setoran()
    {
        return $this->hasMany(Setoran::class);
    }
}
