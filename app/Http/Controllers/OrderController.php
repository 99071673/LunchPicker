<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LunchItem;

class OrderController extends Controller
{
    public function show($location_id)
    {
        $location = Location::findOrFail($location_id);
        $lunchItems = LunchItem::where('location_id', $location_id)->get();

        return view('order.show', compact('location', 'lunchItems'));
    }
}
