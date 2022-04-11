<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    protected $visible = [
        'id',
        'name',
        'image',
        'x3_points',
        'x4_points',
        'x5_points',
    ];
    protected $fillable = [  
        'name',
        'image',
        'x3_points',
        'x4_points',
        'x5_points',
    ];
}
