<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationWallet extends Model
{
    protected $table = 'donation_wallets';

    protected $fillable = [
        'balance',
    ];
}
