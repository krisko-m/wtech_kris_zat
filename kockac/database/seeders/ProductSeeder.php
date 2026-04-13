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
            'image_path' => '/assets/products/Bang/product-bang-1.png',
            'is_main' => true,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/products/Bang/product-bang-2.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/products/Bang/product-bang-3.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => '/assets/products/Bang/product-bang-4.png',
            'is_main' => false,
        ]);

        $product2 = Product::create([
            'name' => 'Hitster',
            'description' => <<<EOT
In the party game Hitster - Special Edition, 2-10 people will compete to see who knows each song better and who can classify them by when they were written.
EOT,
            'gameplay' => <<<EOT
You choose a card, scan the QR code and the song starts playing on Spotify. Your task is to correctly place the song in the timeline. If you guess correctly, you keep the card, if you guess wrong, it remains on the table. Whoever collects 10 cards wins.
EOT,
            'contents' => 'In this version you will find 178 foreign songs.',
            'price' => 25.90,
            'stock_quantity' => 10,
            'recommended_age' => 16,
            'duration' => '30 min',
            'number_of_players' => '2 to 10 players',
            'added' => '2026-01-01',
        ]);

        // Images
        ProductImage::create([
            'product_id' => $product2->product_id,
            'image_path' => '/assets/products/Hitster/product-hitster-1.png',
            'is_main' => true,
        ]);

        ProductImage::create([
            'product_id' => $product2->product_id,
            'image_path' => '/assets/products/Hitster/product-hitster-2.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product2->product_id,
            'image_path' => '/assets/products/Hitster/product-hitster-3.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product2->product_id,
            'image_path' => '/assets/products/Hitster/product-hitster-4.png',
            'is_main' => false,
        ]);

        $product3 = Product::create([
            'name' => 'Catan - Base Game',
            'description' => <<<EOT
Settlers of Catan is an ideal gateway into the magical world of modern board games. The game has relatively simple rules and can be played by anyone.
EOT,
            'gameplay' => <<<EOT
The game uses a completely original game principle - building roads, villages and cities from raw materials that you "mine" by rolling dice at already built settlements. There are five types of building materials on the island of Catan - wood, bricks, sheep, grain and stone (as we have come to use instead of the more correct translation ore or metal). For each building, you need a specific combination of several types and pieces of raw materials. The possibility of trading with opponents gives everyone a chance to really "pump" the one who is looking for the last raw material for the village or city. If you can't come to an agreement with your opponent, you can try to use one of the ports on the game board. To succeed in the game, you need appropriate planning of the development of your villages and cities, business talent, but also that the "right" numbers fall on the dice at least occasionally.

A great advantage of the game is the game board, which is rebuilt from hexagonal fields for each game. Not only is each game different, but everything fits into a small bag if needed, making it easy to take Settlers with you on vacation or a weekend trip.
EOT,
            'contents' => '19 hexagonal pieces with different types of land, 6 frame parts, 95 resource cards, 25 action cards, 4 construction cost cards, 2 special cards, 96 player figures, 2 card compartments, thief figure, 2 dice, 18 number tokens.',
            'price' => 44.99,
            'stock_quantity' => 10,
            'recommended_age' => 10,
            'duration' => '60 - 75 min',
            'number_of_players' => '3 to 4 players',
            'added' => '2026-01-01',
        ]);

        // Images
        ProductImage::create([
            'product_id' => $product3->product_id,
            'image_path' => '/assets/products/Catan/product-catan-1.png',
            'is_main' => true,
        ]);

        ProductImage::create([
            'product_id' => $product3->product_id,
            'image_path' => '/assets/products/Catan/product-catan-2.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product3->product_id,
            'image_path' => '/assets/products/Catan/product-catan-3.png',
            'is_main' => false,
        ]);

        ProductImage::create([
            'product_id' => $product3->product_id,
            'image_path' => '/assets/products/Catan/product-catan-4.png',
            'is_main' => false,
        ]);

    }
}
