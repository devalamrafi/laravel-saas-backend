<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'owner_id');
    }
}
