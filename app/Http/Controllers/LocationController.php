<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        $userVote = Auth::check()
            ? Vote::where('user_id', Auth::id())->first()?->location_id
            : null;

        return view('locations.index', compact('locations', 'userVote'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function submit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Je moet ingelogd zijn om te stemmen.');
        }

        $request->validate([
            'location' => 'required|exists:locations,id',
        ]);

        $userId = Auth::id();

        $vote = Vote::where('user_id', $userId)->first();

        if ($vote) {
            $vote->location_id = $request->location;
            $vote->save();
        } else {
            Vote::create([
                'location_id' => $request->location,
                'user_id' => $userId,
            ]);
        }

        return redirect()->route('home')->with('success', 'Je stem is opgeslagen!');
    }


}
