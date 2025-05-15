<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
        ]);

        // Example with auth
        $user = auth()->user();

        Vote::updateOrCreate(
            ['user_id' => $user->id],
            ['location_id' => $request->location_id]
        );

        return redirect()->back()->with('success', 'Your vote has been recorded!');
    }
}

