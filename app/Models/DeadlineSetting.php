<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeadlineSetting extends Model
{
    protected $fillable = ['locatie_deadline', 'order_deadline'];
    public $timestamps = false;
}
