<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeadlineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('deadline_settings')->updateOrInsert(
            ['id' => 1], // Ensures one fixed row
            [
                'locatie_deadline' => '12:00:00',
                'order_deadline' => '13:00:00',
            ]
        );
    }
}
