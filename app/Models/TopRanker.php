<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopRanker extends Model
{
    protected $fillable = [
        'agent', 'folder_count', 'profit', 'trend', 'global_rank', 'image',
    ];
}
