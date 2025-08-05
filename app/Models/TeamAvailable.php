<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamAvailable extends Model
{
    protected $guarded = [];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamAvailableMember::class, 'team_available_id', 'id');
    }
}
