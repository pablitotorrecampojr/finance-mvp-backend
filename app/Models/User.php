<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Domain\Enums\AccountStatus;
use App\Models\ExpenseCategory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'status',
        'email',
        'password',
        'status',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => AccountStatus::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    //TODO: define relation with user and expense te
    public function expenseCategories()
    {
        return $this->hasMany(ExpenseCategory::class);
    }
}
