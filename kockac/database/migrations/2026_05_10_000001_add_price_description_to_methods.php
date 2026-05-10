<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('delivery_methods', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->default(0);
            $table->text('description')->nullable();
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->text('description')->nullable();
        });

        DB::table('delivery_methods')->where('name', 'Slovenská pošta')->update([
            'price' => 3.99,
            'description' => 'Delivery in 3-5 business days. Tracking number provided.',
        ]);
        DB::table('delivery_methods')->where('name', 'Packeta')->update([
            'price' => 2.99,
            'description' => 'Pick up at your nearest Packeta point. Delivery in 1-2 business days.',
        ]);
        DB::table('delivery_methods')->where('name', 'DHL')->update([
            'price' => 6.99,
            'description' => 'Express delivery in 1-2 business days. Door to door service.',
        ]);
        DB::table('delivery_methods')->where('name', 'Osobný odber')->update([
            'price' => 0.00,
            'description' => 'Pick up at our store in Bratislava. Free of charge.',
        ]);

        DB::table('payment_methods')->where('name', 'Kartou online')->update([
            'description' => 'Pay securely with your credit or debit card. Visa, Mastercard accepted.',
        ]);
        DB::table('payment_methods')->where('name', 'Dobierka')->update([
            'description' => 'Pay cash on delivery. Additional fee of 1,00 € applies.',
        ]);
        DB::table('payment_methods')->where('name', 'Bankovým prevodom')->update([
            'description' => 'Transfer to our bank account. Order ships after payment is confirmed.',
        ]);
    }

    public function down(): void
    {
        Schema::table('delivery_methods', function (Blueprint $table) {
            $table->dropColumn(['price', 'description']);
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
