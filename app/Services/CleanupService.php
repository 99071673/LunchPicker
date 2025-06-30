<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CleanupService
{
    public function clearOrdersAndVotes(): void
    {
        DB::table('orders')->truncate();
        DB::table('votes')->truncate();
    }
}
