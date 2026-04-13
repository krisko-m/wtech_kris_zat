<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::create([
            'name' => 'Bang!',
            'description' => <<<EOT
Bang! is a frantic card shootout for 4-7 players that will take you on an excursion to the Wild West!

Irresistible "Spaghetti Western" atmosphere and constant action. At the beginning, players choose a gunslinger whose character they will play and draw roles. You can become a sheriff or his assistant or, conversely, you will stand on the side of evil as a bandit or even a renegade who fights against everyone!
EOT,
            'gameplay' => <<<EOT
Each player has 3-4 lives depending on which gunman they represent. The sheriff has one more life and starts the game publicly.

The two basic cards are Bang! (shooting) and Mancato! (dodge). During one turn, a player can play only one Bang! card. Beer cards restore one life. Other cards dramatize the game wonderfully.
EOT,
            'contents' => '110 cards, rules',
            'price' => 15.99,
            'stock_quantity' => 10,
            'recommended_age' => 10,
            'duration' => '15 to 45 min',
            'number_of_players' => '4 to 7 players',
            'added' => '2026-01-01',
        ]);

        // Images
        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/product-bang-1.png',
            'is_main' => true,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/product-bang-2.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/product-bang-3.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/product-bang-4.png',
            'is_main' => false,
        ]);

    }
}
