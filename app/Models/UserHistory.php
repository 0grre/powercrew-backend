<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @return void
     */
    public function last_login(): void
    {
        $this->user_id = $this->user_id ?? Auth::user()->getAuthIdentifier();
        $this->last_login_at = Carbon::now();
        $this->save();
    }
}
