<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            [
                'name' => 'paulus frites paleis',
                'address' => 'Smidsweg 23A, 3295 BT s-Gravendeel',
                'image' => 'paulus-frites-paleis.png',
            ],
            [
                'name' => 'Jumbo',
                'address' => 'Kerkstraat 37, 3295 BD s-Gravendeel',
                'image' => 'jumbo.png',
            ],
            [
                'name' => 'Ozzy’s Grillroom',
                'address' => 'Hendrik Hamerstraat 95, 3295 CG s-Gravendeel',
                'image' => 'ozzys-grillroom.png',
            ],
            [
                'name' => 'quickly',
                'address' => 'Zuid Voorstraat 16, 3295 BW s-Gravendeel',
                'image' => 'quickly.png',
            ],
            [
                'name' => 'sushi bar kai',
                'address' => 'Van der Merckstraat 6, 3295 XX s-Gravendeel',
                'image' => 'sushi-bar-kai.png',
            ],
        ]);
    }
}
