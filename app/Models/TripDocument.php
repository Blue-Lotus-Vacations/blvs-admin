<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDocument extends Model
{
    //
    protected $fillable = ['trip_id', 'type', 'file_path', 'name', 'description'];


    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
