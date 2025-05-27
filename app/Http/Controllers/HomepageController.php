<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomepageController extends Controller
{

    public function home(Request $request)
    {
        $timezone = 'Europe/Amsterdam';
        $now = Carbon::now($timezone);

        $locatieStart = Carbon::today($timezone)->setTime(12, 00);
        $locatieDeadline = Carbon::today($timezone)->setTime(14, 15);
        $orderDeadline = Carbon::today($timezone)->setTime(16, 15);

        if ($now->lt($locatieStart)) {
            $status = 'wachten';
        } elseif ($now->lt($locatieDeadline)) {
            $status = 'locatie-stemmen';
        } elseif ($now->lt($orderDeadline)) {
            $status = 'bestellen';
        }

        return view('home', [
            'locatiestart' => $locatieDeadline->format('Y-m-d H:i:s'),
            'locatiedeadline' => $locatieDeadline->format('Y-m-d H:i:s'),
            'orderdeadline' => $orderDeadline->format('Y-m-d H:i:s'),
            'status' => $status,
            'now' => $now->format('Y-m-d H:i:s'),
        ]);
    }
}