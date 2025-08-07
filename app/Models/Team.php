<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $guarded = [];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'team_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function teamAvailable(): HasMany
    {
        return $this->hasMany(TeamAvailable::class, 'team_id', 'id');
    }
}
