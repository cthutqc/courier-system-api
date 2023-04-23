<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function rating():HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function courier_information():HasOne
    {
        return $this->hasOne(CourierInformation::class);
    }

    public function balance():HasOne
    {
        return $this->hasOne(Balance::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function totalReceipts()
    {
        return $this->transactions()->where(Transaction::TRANSACTION_TYPES[0])->summ('amount');
    }
}
