<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Carbon;

class OrderCounter extends Component
{
    public $count;

    public function getOrderCount()
    {
        $this->count = Order::whereDate('updated_at', Carbon::today())->count();
    }

    public function render()
    {
        $this->getOrderCount(); // get fresh count every render
        return view('livewire.order-counter');
    }
}
