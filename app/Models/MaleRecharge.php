<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaleRecharge extends Model
{
    protected $fillable = [
        'account_id',
        'mobile',
        'amount',
        'status',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
