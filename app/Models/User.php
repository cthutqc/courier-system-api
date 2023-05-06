<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\FormattedInformation;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia, Wallet
{
    use HasApiTokens, HasFactory, Notifiable, HasChildren, InteractsWithMedia, HasWallet, FormattedInformation;

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

    protected $childTypes = [
        'admin' => Admin::class,
        'courier' => Courier::class,
        'customer' => Customer::class,
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function personal_information():HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function contact_information():HasOne
    {
        return $this->hasOne(ContactInformation::class);
    }

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isCourier(): bool
    {
        return $this->type === 'courier';
    }

    public function isCustomer(): bool
    {
        return $this->type === 'customer';
    }

    public function address():string
    {
        return $this->contact_information->address();
    }
}
