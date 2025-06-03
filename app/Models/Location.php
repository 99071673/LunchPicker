<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'address',
        'image',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function lunchItems()
    {
        return $this->hasMany(LunchItem::class);
    }

    public function createLunchitems(Location $location)
    {
        return view('lunchitems.create', compact('location'));
    }

    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;
}
