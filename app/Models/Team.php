<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user');
    }
}
