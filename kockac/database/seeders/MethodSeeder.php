<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('delivery_methods')->insert([
            ['name' => 'Slovenská pošta', 'price' => 3.99, 'description' => 'Delivery in 3-5 business days. Tracking number provided.'],
            ['name' => 'Packeta',         'price' => 2.99, 'description' => 'Pick up at your nearest Packeta point. Delivery in 1-2 business days.'],
            ['name' => 'DHL',             'price' => 6.99, 'description' => 'Express delivery in 1-2 business days. Door to door service.'],
            ['name' => 'Osobný odber',    'price' => 0.00, 'description' => 'Pick up at our store in Bratislava. Free of charge.'],
        ]);

        DB::table('payment_methods')->insert([
            ['name' => 'Kartou online',       'description' => 'Pay securely with your credit or debit card. Visa, Mastercard accepted.'],
            ['name' => 'Dobierka',            'description' => 'Pay cash on delivery. Additional fee of 1,00 € applies.'],
            ['name' => 'Bankovým prevodom',   'description' => 'Transfer to our bank account. Order ships after payment is confirmed.'],
        ]);
    }
}
