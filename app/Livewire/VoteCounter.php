<?php

namespace App\Livewire;

use App\Models\Vote;
use Livewire\Component;
use App\Http\Controllers\TimerController;

class VoteCounter extends Component
{
    public $count;

    public function getCount()
    {
        $this->count = Vote::count();
    }

    public function render()
    {
        $this->getCount(); // get fresh count every render

        return view('livewire.vote-counter');
    }
}

