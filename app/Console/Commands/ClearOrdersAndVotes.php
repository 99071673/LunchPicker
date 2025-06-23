<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Vote;

class ClearOrdersAndVotes extends Command
{
    protected $signature = 'orders-votes:clear';

    protected $description = 'Clear all orders and votes from the database.';

    public function handle()
    {
        Order::truncate();
        Vote::truncate();

        $this->info('Orders and votes have been cleared.');
    }
}
