<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    protected $guarded = [];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'team_id', 'id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'team_id', 'id');
    }
}
