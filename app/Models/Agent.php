<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['name', 'image'];

    public function stats()
    {
        return $this->hasMany(AgentStats::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
