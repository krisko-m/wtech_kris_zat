<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_statuses')->insert([
            ['status' => 'pending'],
            ['status' => 'confirmed'],
            ['status' => 'processing'],
            ['status' => 'shipped'],
            ['status' => 'delivered'],
            ['status' => 'cancelled'],
            ['status' => 'refunded'],
        ]);
    }
}
