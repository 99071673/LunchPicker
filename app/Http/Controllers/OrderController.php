<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class OrderController extends Controller
{
    public function show($location_id)
    {
        $location = Location::findOrFail($location_id);  // Haal de locatie op
        return view('order.show', compact('location'));  // Retourneer de juiste view
    }

}
