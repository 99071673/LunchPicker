<?php

namespace App\Http\Controllers;

use App\Models\LunchItem;
use App\Models\Location;
use Illuminate\Http\Request;

class LunchItemController extends Controller
{
    public function create(Request $request)
    {
        $location = Location::findOrFail($request->query('location_id'));
        return view('lunchitems.create', compact('location'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'prijs' => 'required|numeric|min:0',
            'location_id' => 'required|exists:locations,id',
        ]);

        LunchItem::create($validated);
        

        return redirect()
            ->route('bestelling', ['location_id' => $validated['location_id']])
            ->with('success', 'Lunchitem succesvol toegevoegd!');
    }

    public function edit(Location $location)
    {
        return view('admin.lunchitem.edit', compact('location'));
    }
}

