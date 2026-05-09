<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['city' => 'Bratislava', 'postal_code' => '81101', 'country' => 'Slovakia'],
            ['city' => 'Košice',     'postal_code' => '04001', 'country' => 'Slovakia'],
            ['city' => 'Prešov',     'postal_code' => '08001', 'country' => 'Slovakia'],
            ['city' => 'Žilina',     'postal_code' => '01001', 'country' => 'Slovakia'],
            ['city' => 'Banská Bystrica', 'postal_code' => '97401', 'country' => 'Slovakia'],
            ['city' => 'Nitra',      'postal_code' => '94901', 'country' => 'Slovakia'],
            ['city' => 'Trnava',     'postal_code' => '91701', 'country' => 'Slovakia'],
            ['city' => 'Trenčín',    'postal_code' => '91101', 'country' => 'Slovakia'],
        ];

        DB::table('city')->insert($cities);
    }
}
