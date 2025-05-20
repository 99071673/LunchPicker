<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LunchItem extends Model
{
    use HasFactory;

    protected $fillable = ['naam', 'prijs', 'location_id'];
}
