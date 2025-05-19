<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $fillable = [
        'locatie_deadline',
        'order_deadline',
    ];

    protected $casts = [
        'locatie_deadline' => 'integer',
        'order_deadline' => 'integer',
    ];
}
