<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOTP extends Model
{
    //
    protected $fillable = [
        'user_id',
        'value',
        'expires_at'
    ];
}
