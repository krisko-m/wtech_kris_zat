<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        // Vytvor žánre
        $family   = DB::table('genre')->insertGetId(['genre_type' => 'Family'],   'genre_id');
        $puzzle   = DB::table('genre')->insertGetId(['genre_type' => 'Puzzle'],   'genre_id');
        $card     = DB::table('genre')->insertGetId(['genre_type' => 'Card Games'], 'genre_id');
        $strategy = DB::table('genre')->insertGetId(['genre_type' => 'Strategic'], 'genre_id');
        $party    = DB::table('genre')->insertGetId(['genre_type' => 'Party'],    'genre_id');

        // Prirad žánre k hrám
        $assignments = [
            'Bang!'             => [$card, $party, $family],
            'Hitster'           => [$party, $family],
            'Catan - Base Game' => [$strategy, $family],
            'Ticket to Ride'    => [$strategy, $family],
            'Codenames'         => [$party, $card, $family],
            'Pandemic'          => [$strategy, $puzzle],
            'Dobble'            => [$party, $card, $family],
            'Dixit'             => [$party, $family],
            'Azul'              => [$strategy, $puzzle],
            'Skull'             => [$party, $card],
            'Splendor'          => [$strategy, $card],
            'Jenga'             => [$party, $family],
        ];

        foreach ($assignments as $productName => $genreIds) {
            $product = Product::where('name', $productName)->first();
            if (!$product) continue;

            foreach ($genreIds as $genreId) {
                DB::table('genre_of_product')->insert([
                    'genre_id'   => $genreId,
                    'product_id' => $product->product_id,
                ]);
            }
        }
    }
}
