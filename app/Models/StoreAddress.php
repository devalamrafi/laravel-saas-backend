<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreAddress extends Model
{
    protected $fillable = [
        'store_id',
        'address',
        'country',
        'state',
        'city',
        'postal_code',
        'latitude',
        'longitude',
    ];

    public function store(): BelongsTo{
        return $this->belongsTo(Store::class);
    }
}
