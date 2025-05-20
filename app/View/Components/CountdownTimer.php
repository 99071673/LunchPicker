<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CountdownTimer extends Component
{
    public function __construct()
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.countdown-timer');
    }
}
