<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Store extends Model
{
    public function owner(): BelongsTo
        {
            return $this->belongsTo(User::class, 'owner_id');
        }

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'email',
        'phone',
        'description',
        'logo',
        'banner',
        'status',
    ];

    public function address(): HasOne{
        return $this->hasOne(StoreAddress::class);
    }

    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany{
        return $this->hasMany(Category::class);
    }
}
