<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $name = $request->input('name');
        $address = $request->input('address');

        // Create image name like "mcdonalds.jpg"
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = Str::slug($name) . '.' . $extension;

        // Move image to public/images/
        $request->file('image')->move(public_path('images'), $filename);

        // Save location with image name
        Location::create([
            'name' => $name,
            'address' => $address,
            'image' => $filename,
        ]);

        return redirect()->route('admin')->with('success', 'Locatie aangemaakt.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Location $location)
    {
        return view('admin.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $location->name = $request->input('name');
        $location->address = $request->input('address');

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug($location->name) . '.' . $extension;
            $request->file('image')->move(public_path('images'), $filename);
            $location->image = $filename;
        }

        $location->save();

        return redirect()->route('admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Location::destroy($id);

        return redirect(route('admin'));
    }

    public function submit(Request $request)
    {


        Vote::create([
            "location_id" => $request->location,
            "user_id" => Auth::user()->id,
        ]);

        return redirect()->route('home');


    }
}
