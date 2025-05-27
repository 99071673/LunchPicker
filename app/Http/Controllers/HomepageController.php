<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Deadline;

class HomepageController extends Controller
{
    public function home(Request $request)
    {
        $status = $request->query('status', 'wachten');
        $allowedStatuses = ['wachten', 'locatie-stemmen', 'bestellen'];

        if (!in_array($status, $allowedStatuses)) {
            $status = 'wachten';
        }

        $deadline = Carbon::today()->setTime(14, 15);

        return view('home', [
            'deadline' => $deadline->format('Y-m-d H:i:s'),
            'status' => $status,
        ]);
    }

    public function vote()
    {
        $deadline = Carbon::now()->addMinutes(10);

        return view('vote', [
            'deadline' => $deadline->format('Y-m-d H:i:s'),
        ]);
    }

    public function fromDatabase()
    {
        $event = Deadline::latest()->first();

        return view('event', [
            'deadline' => $event->deadline->format('Y-m-d H:i:s'),
        ]);
    }
}
