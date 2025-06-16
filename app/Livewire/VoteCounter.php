<?php

namespace App\Livewire;

use App\Models\Vote;
use Livewire\Component;
use Illuminate\Support\Carbon;

class VoteCounter extends Component
{
    public $count;

    public function getCount()
    {
        $this->count = Vote::whereDate('updated_at', Carbon::today())->count();
    }

    public function render()
    {
        $this->getCount(); // get fresh count every render

        return view('livewire.vote-counter');
    }
}
