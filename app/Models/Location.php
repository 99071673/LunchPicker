<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public function create(Location $location)
    {
        return view('lunchitems.create', compact('location'));
    }
}

