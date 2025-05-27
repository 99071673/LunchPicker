<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::where('email', 'admin@congos.nl')->first();

        if ($user) {
            $user->role = 'admin';
            $user->password = Hash::make('securepassword123');
            $user->save();
        } else {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@congos.nl',
                'password' => Hash::make('securepassword123'),
                'role' => 'admin',
            ]);
        }
    }
}
