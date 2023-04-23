<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ConfirmCode extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = Hash::make($value);
    }
}
