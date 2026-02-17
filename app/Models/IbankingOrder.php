<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbankingOrder extends Model
{
    protected $fillable = [
    'account_id',
    'bank_name_id',
    'account_no',
    'upload_slip',
    'amount',
    'bdt_amount',
    'status',
];

 public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function bank()
    {
        return $this->belongsTo(BankName::class, 'bank_name_id');
    }
    
}
