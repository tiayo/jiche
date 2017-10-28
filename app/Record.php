<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'train',
        'track',
        'arrival_time',
        'locomotive',
        'departure_time'
    ];
}
