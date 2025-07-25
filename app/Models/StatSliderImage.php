<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatSliderImage extends Model
{
    protected $fillable = [
        'url',
        'alt',
        'overlay_text',
    ];
}
