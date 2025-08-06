<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentStats extends Model
{
    protected $fillable = [
        'month',
        'folder_count',
        'profit',
        'agent_id',
        'leads',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
