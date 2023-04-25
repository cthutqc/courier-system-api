<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function ratings():HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function avgRating()
    {
        return $this->ratings()->avg('score');
    }

    public function personal_information():HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function contact_information():HasOne
    {
        return $this->hasOne(ContactInformation::class);
    }

    public function courierOrders():HasMany
    {
        return $this->hasMany(Order::class, 'courier_id');
    }

    public function totalIncome():int
    {
        return $this->payments()
            ->sum('amount');
    }

    public function todayIncome():int
    {
        return $this->payments()
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
    }

    public function todayTips():int
    {
        return $this->payments()
            ->where('payment_status', PaymentStatus::TIPS)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
    }

    public function currentOrders():int
    {
        return $this->courierOrders()->where('status', OrderStatus::ON_DELIVERY)->count();
    }

    public function courier_location():HasOne
    {
        return $this->hasOne(CourierLocation::class);
    }
}
