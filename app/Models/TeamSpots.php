<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamSpots extends Model
{
    protected $guarded = [];

    public function teamAvailables(): BelongsTo
    {
        return $this->belongsTo(TeamAvailable::class, 'team_available_id', 'id');
    }
}
