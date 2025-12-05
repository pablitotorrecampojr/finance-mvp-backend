<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';
    public $timestamps = false;
    public $fillable = [
        'user_id',
        'email',
        'token',
        'expired_at',
        'created_at'
    ];
}
