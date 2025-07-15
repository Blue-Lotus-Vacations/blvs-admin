<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $fillable = [
        'historyid',
        'callid',
        'duration',
        'time_start',
        'time_answered',
        'time_end',
        'reason_terminated',
        'from_no',
        'to_no',
        'from_dn',
        'to_dn',
        'dial_no',
        'reason_changed',
        'final_number',
        'final_dn',
        'bill_code',
        'bill_rate',
        'bill_cost',
        'bill_name',
        'chain',
        'from_type',
        'to_type',
        'final_type',
        'from_dispname',
        'to_dispname',
        'final_dispname',
        'missed_queue_calls'
    ];
}
