<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appSetup extends Model
{
     protected $fillable = [
        'add_balance_content',
        'registered_balance_content',
        'facebook',
        'youtube',
        'telegram',
        'marquee'
    ];
}
