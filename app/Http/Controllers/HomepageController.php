<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\DeadlineSetting;
use App\Models\Order;
use App\Models\Deadline;


class HomepageController extends Controller
{
    public function home(Request $request)
    {
        $timezone = 'Europe/Amsterdam';
        $now = Carbon::now($timezone);

        $deadlines = DeadlineSetting::first();

        $locatieDeadlineTime = $deadlines?->locatie_deadline ?? '14:15:00';
        $orderDeadlineTime = $deadlines?->order_deadline ?? '16:15:00';

        $locatieDeadline = Carbon::today($timezone)->setTimeFromTimeString($locatieDeadlineTime);
        $locatieStart = (clone $locatieDeadline)->subHour();
        $orderDeadline = Carbon::today($timezone)->setTimeFromTimeString($orderDeadlineTime);

        if ($now->lt($locatieStart)) {
            $status = 'wachten';
        } elseif ($now->lt($locatieDeadline)) {
            $status = 'locatie-stemmen';
        } elseif ($now->lt($orderDeadline)) {
            $status = 'bestellen';
        } else {
            $status = 'gesloten';
        }

        $user = Auth::user();
        $order = null;

        if ($user) {
            $order = Order::where('user_id', $user->id)
                ->latest()
                ->first();
        }

        return view('home', [
            'locatiestart' => $locatieStart->format('Y-m-d H:i:s'),
            'locatiedeadline' => $locatieDeadline->format('Y-m-d H:i:s'),
            'orderdeadline' => $orderDeadline->format('Y-m-d H:i:s'),
            'status' => $status,
            'now' => $now->format('Y-m-d H:i:s'),
            'order' => $order,
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
