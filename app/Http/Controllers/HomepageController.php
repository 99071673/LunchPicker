<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\DeadlineSetting;
use App\Models\Order;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    public function home(Request $request)
    {
        $timezone = 'Europe/Amsterdam';
        $now = Carbon::now($timezone);

        $deadlines = DeadlineSetting::first();
        $locatieDeadlineTime = $deadlines?->locatie_deadline ?? '11:15:00';
        $orderDeadlineTime = $deadlines?->order_deadline ?? '16:15:00';

        $locatieDeadline = Carbon::today($timezone)->setTimeFromTimeString($locatieDeadlineTime);
        $locatieStart = (clone $locatieDeadline)->subHour();
        $orderDeadline = Carbon::today($timezone)->setTimeFromTimeString($orderDeadlineTime);
        $winningLocationId = null;
        $winningLocationName = null;



        $status = session()->has('debug_status');
        if (session()->has('debug_status') == false) {
            if ($now->lt($locatieStart)) {
                $status = 'wachten';
            } elseif ($now->lt($locatieDeadline)) {
                $status = 'locatie-stemmen';
            } elseif ($now->lt($orderDeadline)) {
                $status = 'bestellen';

                $winningLocationId = Vote::whereDate('updated_at', now()->setTimezone($timezone))
                    ->selectRaw('location_id, COUNT(*) as vote_count')
                    ->groupBy('location_id')
                    ->orderByDesc('vote_count')
                    ->limit(1)
                    ->value('location_id');

                if ($winningLocationId) {
                    $winningLocationName = Location::findOrFail($winningLocationId)?->name ?? 'Onbekend';

                }

            }
        }

        $user = Auth::user();
        $order = null;
        $location_id = null;
        $location = null;

        if ($user) {
            $order = Order::where('user_id', $user->id)->latest()->first();
            $vote = Vote::where('user_id', $user->id)->first();
            $location_id = $vote?->location_id;
            $location = $location_id ? Location::find($location_id) : null;

            if ($status === 'bestellen' && !$vote) {
                $status = 'locatie-stemmen';
                $locatieDeadline = Carbon::today($timezone)->setTimeFromTimeString($orderDeadlineTime);
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
