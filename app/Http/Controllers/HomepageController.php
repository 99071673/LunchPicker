<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DeadlineSetting;
use App\Models\Order;
use App\Models\Vote;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    public function home(Request $request)
    {
        $timezone = 'Europe/Amsterdam';
        $now = Carbon::now($timezone);

        if (session()->has('debug_status')) {
            $status = session('debug_status');
            $deadlines = DeadlineSetting::first();
            $locatieDeadlineTime = $deadlines?->locatie_deadline ?? '14:15:00';
            $orderDeadlineTime = $deadlines?->order_deadline ?? '16:15:00';

            $locatieDeadline = Carbon::today($timezone)->setTimeFromTimeString($locatieDeadlineTime);
            $locatieStart = (clone $locatieDeadline)->subHour();
            $orderDeadline = Carbon::today($timezone)->setTimeFromTimeString($orderDeadlineTime);
        } else {
            $deadlines = DeadlineSetting::first();
            $locatieDeadlineTime = $deadlines?->locatie_deadline ?? '14:15:00';
            $orderDeadlineTime = $deadlines?->order_deadline ?? '16:15:00';

            $locatieDeadline = Carbon::today($timezone)->setTimeFromTimeString($locatieDeadlineTime);
            $locatieStart = (clone $locatieDeadline)->subHour();
            $orderDeadline = Carbon::today($timezone)->setTimeFromTimeString($orderDeadlineTime);

        $status = 'gesloten';
        $winningLocationId = null;

        if ($now->lt($locatieStart)) {
            $status = 'wachten';
        } elseif ($now->lt($locatieDeadline)) {
            $status = 'locatie-stemmen';
        } elseif ($now->lt($orderDeadline)) {
            $status = 'bestellen';

            // Check if a winning location is already determined for today
            $winningLocationId = Cache::remember('winning_location_' . $now->toDateString(), 86400, function () use ($timezone) {
                return Vote::whereDate('created_at', Carbon::today($timezone))
                    ->select('location_id')
                    ->groupBy('location_id')
                    ->orderByRaw('COUNT(*) DESC')
                    ->limit(1)
                    ->value('location_id');
            });
        }
        $winningLocationName = null;

        if ($winningLocationId) {
            $winningLocation = Location::find($winningLocationId);
            $winningLocationName = $winningLocation?->name ?? 'Onbekend';
        }


        $user = Auth::user();
        $order = null;
        $location_id = null;
        $location = null;

        if ($user) {
            $order = Order::where('user_id', $user->id)->latest()->first();
            $vote = Vote::where('user_id', $user->id)->first();
            $location_id = $vote?->location_id;

            if ($location_id) {
                $location = Location::find($location_id);
            }

            if ($status === 'bestellen' && !$vote) {
                $status = 'locatie-stemmen';
                $locatieDeadline = Carbon::today($timezone)->setTimeFromTimeString($orderDeadlineTime);
            }

            if ($status === 'locatie-stemmen' && $vote) {
                $status = 'bestellen';
            }
        }

        return view('home', [
            'locatiestart' => $locatieStart->format('Y-m-d H:i:s'),
            'locatiedeadline' => $locatieDeadline->format('Y-m-d H:i:s'),
            'orderdeadline' => $orderDeadline->format('Y-m-d H:i:s'),
            'status' => $status,
            'now' => $now->format('Y-m-d H:i:s'),
            'winning_location_id' => $winningLocationId,
            'winning_location_name' => $winningLocationName,
            'order' => $order,
            'location_id' => $location_id,
            'location' => $location,
        ]);
    }
}
