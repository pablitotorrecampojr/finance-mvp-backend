<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'limit',
        'limit_type'
    ];
}
