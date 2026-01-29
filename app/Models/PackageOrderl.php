<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOrderl extends Model
{
    protected $fillable = [
        'package_id',
        'items',
        'number',
        'amount',
        'status',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    
}
