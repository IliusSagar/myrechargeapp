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
}
