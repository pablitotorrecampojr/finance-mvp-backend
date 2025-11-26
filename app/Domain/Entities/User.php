<?php
namespace App\Domain\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 
        'first_name',
        'last_name',
        'email', 
        'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    public static function newFactory()
    {
        return UserFactory::new();
    }
}
