<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileBanking extends Model
{
    protected $fillable = [
        'account_id',
        'mobile_banking_id',
        'number',
        'amount',
        'note_admin',
        'money_status',
        'status',
    ];
}
