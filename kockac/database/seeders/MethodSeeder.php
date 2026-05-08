<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('delivery_methods')->insert([
            ['name' => 'Slovenská pošta'],
            ['name' => 'Packeta'],
            ['name' => 'DHL'],
            ['name' => 'Osobný odber'],
        ]);

        DB::table('payment_methods')->insert([
            ['name' => 'Kartou online'],
            ['name' => 'Dobierka'],
            ['name' => 'Bankovým prevodom'],
        ]);
    }
}
