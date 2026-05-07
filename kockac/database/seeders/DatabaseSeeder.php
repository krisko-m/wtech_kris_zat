<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'first_name' => 'Freddy',
            'last_name'  => 'Fazbear',
            'username'   => 'freddy1',
            'email'      => 'fivenights@freddy.sk',
            'password'   => Hash::make('123456789'),
            'is_admin'   => false,
        ]);

        User::create([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('admin123'),
            'is_admin'   => true,
        ]);
    }
}
