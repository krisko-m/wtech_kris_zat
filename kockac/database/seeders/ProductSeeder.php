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
            'duration_min' => 15, 'duration_max' => 45,
            'players_min' => 4, 'players_max' => 7,
            'added' => '2026-01-01',
            'author' => 'Emiliano Sciarra',
            'publisher' => 'dV Giochi',
            'complexity' => 'Beginner',
        ]);

        ProductImage::create(['product_id' => $product->product_id, 'image_path' => '/assets/products/Bang/product-bang-1.png', 'is_main' => true]);
        ProductImage::create(['product_id' => $product->product_id, 'image_path' => '/assets/products/Bang/product-bang-2.png', 'is_main' => false]);
        ProductImage::create(['product_id' => $product->product_id, 'image_path' => '/assets/products/Bang/product-bang-3.png', 'is_main' => false]);
        ProductImage::create(['product_id' => $product->product_id, 'image_path' => '/assets/products/Bang/product-bang-4.png', 'is_main' => false]);

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
            'duration_min' => 30, 'duration_max' => 30,
            'players_min' => 2, 'players_max' => 10,
            'added' => '2026-01-01',
            'author' => 'Marcus Carleson',
            'publisher' => 'Jumbo',
            'complexity' => 'Beginner',
        ]);

        ProductImage::create(['product_id' => $product2->product_id, 'image_path' => '/assets/products/Hitster/product-hitster-1.png', 'is_main' => true]);
        ProductImage::create(['product_id' => $product2->product_id, 'image_path' => '/assets/products/Hitster/product-hitster-2.png', 'is_main' => false]);
        ProductImage::create(['product_id' => $product2->product_id, 'image_path' => '/assets/products/Hitster/product-hitster-3.png', 'is_main' => false]);
        ProductImage::create(['product_id' => $product2->product_id, 'image_path' => '/assets/products/Hitster/product-hitster-4.png', 'is_main' => false]);

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
            'duration_min' => 60, 'duration_max' => 75,
            'players_min' => 3, 'players_max' => 4,
            'added' => '2026-01-01',
            'author' => 'Klaus Teuber',
            'publisher' => 'CATAN Studio',
            'complexity' => 'Gateway',
        ]);

        ProductImage::create(['product_id' => $product3->product_id, 'image_path' => '/assets/products/Catan/product-catan-1.png', 'is_main' => true]);
        ProductImage::create(['product_id' => $product3->product_id, 'image_path' => '/assets/products/Catan/product-catan-2.png', 'is_main' => false]);
        ProductImage::create(['product_id' => $product3->product_id, 'image_path' => '/assets/products/Catan/product-catan-3.png', 'is_main' => false]);
        ProductImage::create(['product_id' => $product3->product_id, 'image_path' => '/assets/products/Catan/product-catan-4.png', 'is_main' => false]);

        $product4 = Product::create([
            'name' => 'Ticket to Ride',
            'description' => <<<EOT
Ticket to Ride is a cross-country train adventure game where players collect cards of various types of train cars and use them to claim railway routes connecting cities throughout North America.
EOT,
            'gameplay' => <<<EOT
Draw destination tickets and try to connect the cities shown. Collect colored train cards and spend them to claim routes. Longer routes score more points. Bonus points for completed destinations, penalty for incomplete ones.
EOT,
            'contents' => '1 board map, 240 colored train cars, 110 train car cards, 30 destination tickets, 5 scoring markers, 1 summary card',
            'price' => 49.99,
            'stock_quantity' => 12,
            'recommended_age' => 8,
            'duration_min' => 45, 'duration_max' => 90,
            'players_min' => 2, 'players_max' => 5,
            'added' => '2026-01-01',
            'author' => 'Alan R. Moon',
            'publisher' => 'Days of Wonder',
            'complexity' => 'Gateway',
        ]);

        ProductImage::create(['product_id' => $product4->product_id, 'image_path' => '/assets/products/TicketToRide/ttr-1.png', 'is_main' => true]);

        $product5 = Product::create([
            'name' => 'Codenames',
            'description' => <<<EOT
Codenames is a social word game with a simple premise: two rival spymasters know the secret identities of 25 agents. Their teammates know the agents only by their codenames.
EOT,
            'gameplay' => <<<EOT
Two teams compete to see who can make contact with all of their agents first. Spymasters give one-word clues that can point to multiple words on the board. Their teammates try to guess which words belong to their team while avoiding the opposing team and the deadly assassin.
EOT,
            'contents' => '200 double-sided word cards, 40 key cards, 1 card stand, 1 rulebook',
            'price' => 19.99,
            'stock_quantity' => 20,
            'recommended_age' => 14,
            'duration_min' => 15, 'duration_max' => 30,
            'players_min' => 2, 'players_max' => 8,
            'added' => '2026-01-01',
            'author' => 'Vlaada Chvátil',
            'publisher' => 'Czech Games Edition',
            'complexity' => 'Gateway',
        ]);

        ProductImage::create(['product_id' => $product5->product_id, 'image_path' => '/assets/products/Codenames/codenames-1.png', 'is_main' => true]);

        $product6 = Product::create([
            'name' => 'Pandemic',
            'description' => <<<EOT
Pandemic is a cooperative game where players work together as a team of specialists to treat infections around the world while gathering resources for cures.
EOT,
            'gameplay' => <<<EOT
Players take on unique roles with special abilities and travel the globe treating diseases and building research stations. Each turn diseases spread further. Find cures for all four diseases before outbreaks get out of control.
EOT,
            'contents' => '1 board, 5 role cards, 7 reference cards, 6 research stations, 96 disease cubes, 48 infection cards, 58 player cards, 4 cure markers, 1 infection rate marker, 1 outbreak marker',
            'price' => 39.99,
            'stock_quantity' => 8,
            'recommended_age' => 8,
            'duration_min' => 45, 'duration_max' => 75,
            'players_min' => 2, 'players_max' => 4,
            'added' => '2026-01-01',
            'author' => 'Matt Leacock',
            'publisher' => 'Z-Man Games',
            'complexity' => 'Intermediate',
        ]);

        ProductImage::create(['product_id' => $product6->product_id, 'image_path' => '/assets/products/Pandemic/pandemic-1.png', 'is_main' => true]);

        $product7 = Product::create([
            'name' => 'Dobble',
            'description' => <<<EOT
Dobble is a speedy observation game where players race to find the one matching symbol between any two cards. Simple to learn, impossible to put down!
EOT,
            'gameplay' => <<<EOT
Every two cards share exactly one identical symbol. Be the first to spot it and call it out! Features 5 mini games that can be played with the same deck, keeping things fresh every time.
EOT,
            'contents' => '55 cards, 1 tin',
            'price' => 13.99,
            'stock_quantity' => 25,
            'recommended_age' => 6,
            'duration_min' => 15, 'duration_max' => 15,
            'players_min' => 2, 'players_max' => 8,
            'added' => '2026-01-01',
            'author' => 'Denis Blanchot',
            'publisher' => 'Asmodee',
            'complexity' => 'Beginner',
        ]);

        ProductImage::create(['product_id' => $product7->product_id, 'image_path' => '/assets/products/Dobble/dobble-1.png', 'is_main' => true]);

        $product8 = Product::create([
            'name' => 'Dixit',
            'description' => <<<EOT
Dixit is a beautifully illustrated storytelling game where your imagination unlocks the tale. Using cards depicting dreamlike illustrations, players try to guess each other\'s stories.
EOT,
            'gameplay' => <<<EOT
One player is the storyteller and gives a clue about their card. Other players choose a card from their hand that best fits the clue. All chosen cards are shuffled and revealed — players vote on which card belongs to the storyteller. Score points for correct guesses but not if everyone or no one guesses correctly.
EOT,
            'contents' => '84 image cards, 36 voting tokens, 6 wooden rabbit pawns, 1 score track',
            'price' => 29.99,
            'stock_quantity' => 10,
            'recommended_age' => 8,
            'duration_min' => 30, 'duration_max' => 30,
            'players_min' => 3, 'players_max' => 6,
            'added' => '2026-01-01',
            'author' => 'Jean-Louis Roubira',
            'publisher' => 'Libellud',
            'complexity' => 'Beginner',
        ]);

        ProductImage::create(['product_id' => $product8->product_id, 'image_path' => '/assets/products/Dixit/dixit-1.png', 'is_main' => true]);

        $product9 = Product::create([
            'name' => 'Azul',
            'description' => <<<EOT
Azul is an abstract strategy game where players draft colored tiles to complete patterns on their personal boards, scoring points for completed rows, columns and sets.
EOT,
            'gameplay' => <<<EOT
Players take turns drafting colored tiles from suppliers and adding them to their pattern lines. When a line is completed, one tile moves to the wall and scores points. Leftover tiles incur penalties. The game ends when someone completes a horizontal line on their wall.
EOT,
            'contents' => '100 resin tiles, 4 player boards, 9 factory displays, 1 score board, 4 scoring markers, 1 first player marker, 1 bag, 1 lid',
            'price' => 34.99,
            'stock_quantity' => 14,
            'recommended_age' => 8,
            'duration_min' => 30, 'duration_max' => 45,
            'players_min' => 2, 'players_max' => 4,
            'added' => '2026-01-01',
            'author' => 'Michael Kiesling',
            'publisher' => 'Next Move Games',
            'complexity' => 'Gateway',
        ]);

        ProductImage::create(['product_id' => $product9->product_id, 'image_path' => '/assets/products/Azul/azul-1.png', 'is_main' => true]);

        $product10 = Product::create([
            'name' => 'Skull',
            'description' => <<<EOT
Skull is a bluffing game played with beautifully designed coasters. Place flowers or a skull, then bet on how many flowers you can flip without hitting a skull.
EOT,
            'gameplay' => <<<EOT
Each player places one of their coasters face down. Players then bid on how many coasters they can flip revealing only flowers. The highest bidder must flip that many coasters starting with their own. Hit a skull and lose a coaster. Win two bids and you win the game.
EOT,
            'contents' => '24 double-sided coasters, 6 player mats',
            'price' => 22.99,
            'stock_quantity' => 18,
            'recommended_age' => 10,
            'duration_min' => 15, 'duration_max' => 45,
            'players_min' => 3, 'players_max' => 6,
            'added' => '2026-01-01',
            'author' => 'Hervé Marly',
            'publisher' => 'Space Cowboys',
            'complexity' => 'Beginner',
        ]);

        ProductImage::create(['product_id' => $product10->product_id, 'image_path' => '/assets/products/Skull/skull-1.png', 'is_main' => true]);

        $product11 = Product::create([
            'name' => 'Splendor',
            'description' => <<<EOT
Splendor is a chip collecting and card development game where you are a Renaissance merchant trying to buy gem mines, means of transportation, shops — and recruiting artisans.
EOT,
            'gameplay' => <<<EOT
Collect gem tokens to buy development cards. Cards give you permanent gem bonuses making future purchases cheaper. Use cards to attract noble tiles worth prestige points. First player to reach 15 prestige points triggers the final round.
EOT,
            'contents' => '40 development cards, 10 noble tiles, 36 poker-style chips, 7 gold joker chips',
            'price' => 32.99,
            'stock_quantity' => 11,
            'recommended_age' => 10,
            'duration_min' => 30, 'duration_max' => 30,
            'players_min' => 2, 'players_max' => 4,
            'added' => '2026-01-01',
            'author' => 'Marc André',
            'publisher' => 'Space Cowboys',
            'complexity' => 'Gateway',
        ]);

        ProductImage::create(['product_id' => $product11->product_id, 'image_path' => '/assets/products/Splendor/splendor-1.png', 'is_main' => true]);

        $product12 = Product::create([
            'name' => 'Jenga',
            'description' => <<<EOT
Jenga is the classic block stacking and stack crashing game! Stack the blocks up in a sturdy tower then take turns pulling out blocks one by one until the whole stack falls down.
EOT,
            'gameplay' => <<<EOT
Build the tower by stacking blocks in sets of three placed in alternating directions. On your turn remove one block from any level below the highest completed story and place it on top. The player who causes the tower to fall loses!
EOT,
            'contents' => '54 hardwood blocks, stacking sleeve with instructions',
            'price' => 17.99,
            'stock_quantity' => 30,
            'recommended_age' => 6,
            'duration_min' => 20, 'duration_max' => 20,
            'players_min' => 2, 'players_max' => null,
            'added' => '2026-01-01',
            'author' => 'Leslie Scott',
            'publisher' => 'Hasbro',
            'complexity' => 'Beginner',
        ]);

        ProductImage::create(['product_id' => $product12->product_id, 'image_path' => '/assets/products/Jenga/jenga-1.png', 'is_main' => true]);
    }
}
