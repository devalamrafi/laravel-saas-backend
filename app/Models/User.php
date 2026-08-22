<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'owner_id');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
