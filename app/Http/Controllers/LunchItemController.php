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
            ->route('location.edit', [$validated['location_id']])
            ->with('success', 'Lunchitem succesvol toegevoegd!');
    }

    public function edit(Location $location, $lunchItem)
    {
//        dd(LunchItem::find($lunchItem));
        $lunchItem = LunchItem::find($lunchItem);

        return view('admin.lunchitem.edit', compact('location', 'lunchItem'));
    }

    public function update(Request $request, $location, LunchItem $lunchItem)
    {

        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'prijs' => 'required|numeric|min:0',
        ]);

//        $lunchItem = LunchItem::find($lunchItem);


        $lunchItem->update($validated);

        return redirect()
            ->route('location.edit', [$location])
            ->with('success', 'Lunch item succesvol bijgewerkt.');
    }
    public function destroy(string $id)
    {
        $lunchItem = LunchItem::findOrFail($id); // Get the item or fail if not found

        $locationId = $lunchItem->location_id;   // Access the location_id

        // You can now use $locationId as needed before deleting
        $lunchItem->delete();                    // Delete the lunch item

        return redirect(route('location.edit', $locationId));
    }

}

