<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TimerController extends Controller
{
    public function home()
    {
    
        $deadline = Carbon::today()->setTime(14, 15); 

        return view('home', [
            'deadline' => $deadline->format('Y-m-d H:i:s'),
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
        $event = \App\Models\Deadline::latest()->first();

        return view('event', [
            'deadline' => $event->deadline->format('Y-m-d H:i:s'),
        ]);
    }
}
