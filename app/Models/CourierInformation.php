<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourierInformation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function courier():BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }
}
