<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\DeadlineSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\CleanupService;

class AdminController extends Controller
{
    // Show admin dashboard with users, locations, and deadlines
    public function index()
    {
        $users = User::all();
        $locations = Location::all();
        $deadlines = DeadlineSetting::first();

        return view('admin.index', [
            'users' => $users,
            'locations' => $locations,
            'locatie_deadline' => $deadlines?->locatie_deadline
                ? Carbon::parse($deadlines->locatie_deadline)->format('H:i')
                : null,
            'order_deadline' => $deadlines?->order_deadline
                ? Carbon::parse($deadlines->order_deadline)->format('H:i')
                : null,
        ]);
    }

    public function updateDeadlines(Request $request)
    {
        $request->validate([
            'locatie_deadline' => 'required|date_format:H:i',
            'order_deadline' => 'required|date_format:H:i',
        ]);

        DeadlineSetting::updateOrCreate(
            ['id' => 1],
            [
                'locatie_deadline' => Carbon::createFromFormat('H:i', $request->locatie_deadline)->format('H:i:s'),
                'order_deadline' => Carbon::createFromFormat('H:i', $request->order_deadline)->format('H:i:s'),
            ]
        );

        return redirect()->route('admin')->with('success', 'Deadlines succesvol bijgewerkt.');
    }

    public function setStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:wachten,locatie-stemmen,bestellen,gesloten',
        ]);

        session(['debug_status' => $request->status]);

        return back()->with('success', 'Debug status set to: ' . $request->status);
    }

    public function clearStatus()
    {
        session()->forget('debug_status');

        return back()->with('success', 'Debug status cleared.');
    }

    public function clearOrdersAndVotes(CleanupService $cleanupService)
    {
        $cleanupService->clearOrdersAndVotes();

        return back()->with('success', 'Alle bestellingen en stemmen zijn verwijderd.');
    }
}