<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopFolder  extends Model
{
    protected $fillable = ['agent', 'folder_count', 'trend', 'global_rank', 'image'];
}
