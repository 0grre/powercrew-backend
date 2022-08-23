<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHistory extends History
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_login_at',
    ];
}
