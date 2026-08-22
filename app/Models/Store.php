<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
