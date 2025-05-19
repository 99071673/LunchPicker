<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LunchItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Request $request, $location_id)
    {
        $location = Location::findOrFail($location_id);

        $query = $request->input('search');

        $lunchItems = LunchItem::where('location_id', $location_id)
            ->when($query, function ($q) use ($query) {
                return $q->where('naam', 'like', '%' . $query . '%');
            })
            ->get();

        return view('order.show', compact('location', 'lunchItems'));
    }
}
