<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $fillable = [
        'caller_number',
        'agent_extension',
        'missed_at',
        'status',
    ];
}
