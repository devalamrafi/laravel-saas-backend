<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
      protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function store(): BelongsTo{
        return $this->belongsTo(Store::class);
    }
}
