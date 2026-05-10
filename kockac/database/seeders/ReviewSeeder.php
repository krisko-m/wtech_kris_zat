<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('username', 'freddy1')->first();

        $reviews = [
            'Bang!' => [
                [
                    'message' => 'Absolutely love this game! The Wild West theme is immersive and the gameplay is fast-paced. Perfect for game nights with friends. Every round feels different and exciting.',
                    'stars' => 5,
                    'created_at' => '2026-01-15 10:00:00',
                ],
                [
                    'message' => 'Great party game once you get the hang of the rules. The role-based gameplay keeps everyone on their toes. Can get a bit chaotic with 7 players but that\'s part of the fun!',
                    'stars' => 4,
                    'created_at' => '2026-05-2 10:00:00',
                ],
            ],
            'Hitster' => [
                [
                    'message' => 'Such a fun concept! Scanning the QR codes and hearing the songs is a blast. We spent hours arguing about which year songs came out. Highly recommend for music lovers.',
                    'stars' => 5,
                    'created_at' => '2026-01-15 10:00:00',
                ],
                [
                    'message' => 'Really enjoyed this one. The timeline mechanic is simple but surprisingly tricky. Some older songs are hard if you\'re younger, but that\'s what makes it interesting.',
                    'stars' => 4,
                    'created_at' => '2026-04-12 10:00:00',
                ],
            ],
            'Catan - Base Game' => [
                [
                    'message' => 'The gateway drug of board games. Catan introduced me to modern board gaming and I\'ve never looked back. Trading, building, strategy - it has everything. A timeless classic.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Great game but can run long with new players. The trading mechanic is what sets it apart. Be warned - it may cause arguments between friends over wheat and ore.',
                    'stars' => 4,
                ],
            ],
            'Ticket to Ride' => [
                [
                    'message' => 'One of the best gateway games out there. Easy to learn, hard to master. Watching your opponents block your routes is both infuriating and hilarious. Brilliant design.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Clean mechanics and beautiful components. The tension of claiming routes before others is addictive. Great for families and casual gamers alike.',
                    'stars' => 4,
                ],
            ],
            'Codenames' => [
                [
                    'message' => 'Possibly the best party game ever made. The one-word clue mechanic is genius. Every round leads to moments of brilliance and confusion. Works great with any group size.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Simple rules, deep gameplay. Being the spymaster is stressful in the best way. A must-have for any game collection. We play this almost every weekend.',
                    'stars' => 5,
                ],
            ],
            'Pandemic' => [
                [
                    'message' => 'The best cooperative game I\'ve played. Working together to stop global outbreaks is genuinely tense. The difficulty scales well and every game tells a different story.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Challenging and rewarding. Be ready to lose a lot at first but the wins feel incredibly satisfying. Great for players who prefer working together over competing.',
                    'stars' => 4,
                ],
            ],
            'Dobble' => [
                [
                    'message' => 'Deceptively simple and insanely addictive. Perfect for all ages. We play this as a warm-up before longer games. The speed element keeps everyone engaged.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Great filler game. Fast rounds mean you can play multiple times in a row. Kids love it as much as adults. The tin packaging is a nice touch.',
                    'stars' => 4,
                ],
            ],
            'Dixit' => [
                [
                    'message' => 'The artwork alone is worth the price. A beautiful and creative game that sparks imagination. Perfect for players who enjoy storytelling and abstract thinking.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Unique and charming. Not for competitive types but perfect for creative groups. The clue-giving mechanic leads to fascinating and funny moments.',
                    'stars' => 4,
                ],
            ],
            'Azul' => [
                [
                    'message' => 'Stunning components and tight gameplay. Drafting tiles and building your wall is deeply satisfying. Easy to teach but offers real strategic depth. One of my all-time favourites.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Elegant design with beautiful resin tiles. The game feels premium and plays brilliantly. Blocking opponents adds a nice competitive edge without being mean-spirited.',
                    'stars' => 5,
                ],
            ],
            'Skull' => [
                [
                    'message' => 'Pure bluffing perfection. So simple yet so psychological. Reading your opponents and knowing when to bet big is incredibly satisfying. Great with 4-6 players.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Underrated gem. The coaster components are gorgeous and the gameplay is tense. Perfect pub game. Anyone can learn it in two minutes and master it never.',
                    'stars' => 4,
                ],
            ],
            'Splendor' => [
                [
                    'message' => 'Smooth engine-building at its finest. Collecting gems to buy cards that give permanent bonuses feels great. Quick to learn and plays in under 30 minutes. Highly replayable.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Elegant and satisfying. The chip tokens feel luxurious and the card progression is well balanced. A must for fans of resource management games.',
                    'stars' => 4,
                ],
            ],
            'Jenga' => [
                [
                    'message' => 'A true classic that never gets old. The tension as the tower wobbles is unmatched. Works for all ages and needs no explanation. Every tumble brings the table to life.',
                    'stars' => 5,
                ],
                [
                    'message' => 'Simple, tactile, and thrilling. Jenga is one of those games that always gets people laughing. The wooden blocks feel solid and durable. A timeless party staple.',
                    'stars' => 4,
                ],
            ],
        ];

        foreach ($reviews as $productName => $productReviews) {
            $product = Product::where('name', $productName)->first();
            if (!$product) continue;

            foreach ($productReviews as $review) {
                DB::table('reviews')->insert([
                    'product_id' => $product->product_id,
                    'user_id'    => $user->id,
                    'message'    => $review['message'],
                    'stars'      => $review['stars'],
                    'created_at' => $review['created_at'] ?? now(),
                ]);
            }
        }
    }
}
